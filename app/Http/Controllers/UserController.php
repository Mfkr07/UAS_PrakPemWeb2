<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function home()
    {
        // Get all active bookings (booked or active) for the user
        $activeBookings = \App\Models\Booking::where('user_id', auth()->id())
                            ->whereIn('status', ['booked', 'active'])
                            ->with('computer')
                            ->orderBy('start_time', 'asc')
                            ->get();

        $historyBookings = \App\Models\Booking::where('user_id', auth()->id())
                            ->whereIn('status', ['completed', 'cancelled'])
                            ->with('computer')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('user.home', compact('activeBookings', 'historyBookings'));
    }

    public function billing()
    {
        $computers = \App\Models\Computer::orderBy('name')->get();
        $canteenItems = \App\Models\CanteenItem::all();
        
        return view('user.billing', compact('computers', 'canteenItems'));
    }

    public function processBilling(Request $request)
    {
        $request->validate([
            'pc_id' => 'required|exists:computers,id',
            'duration' => 'required',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $computer = \App\Models\Computer::findOrFail($request->pc_id);

        $bookingDateTimeString = $request->booking_date . ' ' . $request->booking_time;
        $bookingTime = \Carbon\Carbon::parse($bookingDateTimeString);

        if ($bookingTime->isPast()) {
            // Allow a small 5 minute grace period for "now" selections
            if ($bookingTime->diffInMinutes(now()) > 5) {
                return back()->with('error', 'Waktu booking tidak boleh di masa lalu.');
            }
            $bookingTime = now();
        }

        $durationHours = (int) $request->duration;
        $price = $computer->price_per_hour * $durationHours;
        $packageType = 'regular';

        $endTime = $bookingTime->copy()->addHours($durationHours);

        // Check for overlapping bookings (booked or active)
        $overlapping = \App\Models\Booking::where('computer_id', $computer->id)
            ->whereIn('status', ['booked', 'active'])
            ->where(function($query) use ($bookingTime, $endTime) {
                $query->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $bookingTime);
            })->exists();

        if ($overlapping) {
            return back()->with('error', 'PC sudah dipesan pada waktu tersebut. Silakan pilih waktu atau PC lain.');
        }

        $canteenTotal = 0;
        $orderedItems = [];
        
        if ($request->has('canteen_items')) {
            foreach ($request->canteen_items as $itemId => $quantity) {
                if ($quantity > 0) {
                    $item = \App\Models\CanteenItem::find($itemId);
                    if ($item) {
                        $sub = $item->price * $quantity;
                        $canteenTotal += $sub;
                        $orderedItems[] = [
                            'canteen_item_id' => $item->id,
                            'quantity' => $quantity,
                            'subtotal' => $sub
                        ];
                    }
                }
            }
        }

        $totalPrice = $price + $canteenTotal;
        $user = auth()->user();

        if ($user->wallet_balance < $totalPrice) {
            return back()->with('error', 'Saldo Wallet tidak mencukupi.');
        }

        $user->wallet_balance -= $totalPrice;
        $user->save();

        $booking = \App\Models\Booking::create([
            'user_id' => $user->id,
            'computer_id' => $computer->id,
            'duration_hours' => $durationHours,
            'package_type' => $packageType,
            'start_time' => $bookingTime,
            'end_time' => $endTime,
            'total_price' => $totalPrice,
            'status' => 'booked'
        ]);

        foreach ($orderedItems as $orderedItem) {
            $booking->canteenItems()->create($orderedItem);
        }

        return redirect()->route('billing.success')->with('booking_id', $booking->id);
    }

    public function billingSuccess()
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = \App\Models\Booking::with(['computer', 'canteenItems.canteenItem'])->findOrFail($bookingId);
        
        return view('user.billing_success', compact('booking'));
    }

    public function receiptView($id)
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->with(['user', 'computer', 'canteenItems.canteenItem'])
            ->findOrFail($id);

        return view('user.receipt', compact('booking'));
    }

    public function receiptPdf($id)
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->with(['user', 'computer', 'canteenItems.canteenItem'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('user.receipt_pdf', compact('booking'));
        $pdf->setPaper([0, 0, 300, 600], 'portrait');

        return $pdf->download('struk_booking_WA-' . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function cancelBooking($id)
    {
        $booking = \App\Models\Booking::where('user_id', auth()->id())
            ->where('id', $id)
            ->where('status', 'booked')
            ->firstOrFail();

        // Cancel without refund
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('home')->with('success', 'Booking berhasil dibatalkan. Catatan: saldo tidak dikembalikan.');
    }

    public function history()
    {
        $bookings = \App\Models\Booking::where('user_id', auth()->id())->with('computer')->latest()->get();
        return view('user.history', compact('bookings'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ]);

        $user = auth()->user();
        $user->wallet_balance += $request->amount;
        $user->save();

        return redirect()->back()->with('success', 'Top-Up sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil ditambahkan ke e-Wallet Anda.');
    }
}
