<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function pcIndex()
    {
        $computers = \App\Models\Computer::orderBy('name')->get();
        return view('admin.pc_index', compact('computers'));
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

    public function bookingIndex()
    {
        $bookings = \App\Models\Booking::with(['user', 'computer', 'canteenItems'])->latest()->get();
        return view('admin.booking_index', compact('bookings'));
    }

    public function finishBooking($id)
    {
        $booking = \App\Models\Booking::findOrFail($id);
        
        if ($booking->computer) {
            $booking->computer->update(['status' => 'available']);
        }
        
        $booking->update([
            'status' => 'completed',
            'end_time' => now()
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Sesi berhasil diakhiri.');
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
