<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\BookingsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        $totalPcs = \App\Models\Computer::count();
        $totalBookings = \App\Models\Booking::count();
        $totalRevenue = \App\Models\Booking::sum('total_price');

        // Revenue Chart Data (Last 7 Days)
        $revenueData = \App\Models\Booking::selectRaw('DATE(created_at) as date, SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartLabels = $revenueData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        })->toArray();
        $chartValues = $revenueData->pluck('revenue')->toArray();

        return view('admin.dashboard', compact('totalUsers', 'totalPcs', 'totalBookings', 'totalRevenue', 'chartLabels', 'chartValues'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function pcIndex()
    {
        $computers = \App\Models\Computer::orderBy('name')->get();

        // Load upcoming bookings for each PC (today and future, booked or active)
        $upcomingBookings = \App\Models\Booking::whereIn('status', ['booked', 'active'])
            ->where('end_time', '>=', now())
            ->with('user')
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy('computer_id');

        return view('admin.pc_index', compact('computers', 'upcomingBookings'));
    }

    public function pcStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price_per_hour' => 'required|numeric'
        ]);

        \App\Models\Computer::create([
            'name' => $request->name,
            'price_per_hour' => $request->price_per_hour,
            'status' => 'available'
        ]);

        return redirect()->back()->with('success', 'PC berhasil ditambahkan.');
    }

    public function pcDestroy($id)
    {
        \App\Models\Computer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'PC dihapus.');
    }

    public function bookingIndex(Request $request)
    {
        $query = \App\Models\Booking::with(['user', 'computer', 'canteenItems'])->latest();

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('pc_category')) {
            $query->whereHas('computer', function($q) use ($request) {
                $q->where('price_per_hour', $request->pc_category);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->get();
        $categories = \App\Models\Computer::select('price_per_hour')->distinct()->orderBy('price_per_hour')->get();

        return view('admin.booking_index', compact('bookings', 'categories'));
    }

    public function exportPdf(Request $request)
    {
        $query = \App\Models\Booking::with(['user', 'computer', 'canteenItems'])->latest();

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('pc_category')) {
            $query->whereHas('computer', function($q) use ($request) {
                $q->where('price_per_hour', $request->pc_category);
            });
        }

        $bookings = $query->get();
        $pdf = Pdf::loadView('admin.bookings_pdf', compact('bookings'));
        return $pdf->download('rekapitulasi_pendapatan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = \App\Models\Booking::with(['user', 'computer', 'canteenItems'])->latest();

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('pc_category')) {
            $query->whereHas('computer', function($q) use ($request) {
                $q->where('price_per_hour', $request->pc_category);
            });
        }

        $bookings = $query->get();
        return Excel::download(new BookingsExport($bookings), 'rekapitulasi_pendapatan.xlsx');
    }

    /**
     * Admin manually checks in a booked booking.
     * Changes booking status: booked → active
     * Changes PC status: available → in_use
     */
    public function checkinBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);

        if ($booking->status !== 'booked') {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking ini tidak dalam status "booked".');
        }

        $booking->update(['status' => 'active']);

        if ($booking->computer) {
            $booking->computer->update(['status' => 'in_use']);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Check-In berhasil! PC ' . ($booking->computer->name ?? '') . ' sekarang aktif digunakan.');
    }

    /**
     * Admin manually checks out an active booking.
     * Changes booking status: active → completed
     * Changes PC status: in_use → available
     */
    public function checkoutBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);

        if ($booking->status !== 'active') {
            return redirect()->route('admin.bookings.index')->with('error', 'Booking ini tidak dalam status "active".');
        }

        $booking->update([
            'status' => 'completed',
        ]);

        if ($booking->computer) {
            $booking->computer->update(['status' => 'available']);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Check-Out berhasil! Sesi PC ' . ($booking->computer->name ?? '') . ' telah selesai.');
    }

    public function usersIndex()
    {
        $users = \App\Models\User::where('role', 'user')->latest()->get();
        return view('admin.users_index', compact('users'));
    }

    public function usersDestroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus admin.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }

    public function canteenIndex()
    {
        $canteenItems = \App\Models\CanteenItem::latest()->get();
        return view('admin.canteen_index', compact('canteenItems'));
    }

    public function canteenStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $imagePath = '/images/' . $imageName;
        }

        \App\Models\CanteenItem::create([
            'name' => $request->name,
            'price' => $request->price,
            'image_path' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    public function canteenUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $item = \App\Models\CanteenItem::findOrFail($id);
        $imagePath = $item->image_path;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $imagePath = '/images/' . $imageName;
        }

        $item->update([
            'name' => $request->name,
            'price' => $request->price,
            'image_path' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    public function canteenDestroy($id)
    {
        \App\Models\CanteenItem::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus.');
    }
}
