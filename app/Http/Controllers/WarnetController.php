<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarnetController extends Controller
{
    public function index()
    {
        $computers = \App\Models\Computer::orderBy('name')->get();
        return view('warnet.dashboard', compact('computers'));
    }

    public function book($id)
    {
        $computer = \App\Models\Computer::findOrFail($id);
        if ($computer->status === 'in_use') {
            return redirect()->route('dashboard')->with('error', 'PC sedang digunakan.');
        }
        return view('warnet.book', compact('computer'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'duration_hours' => 'required|integer|min:1|max:24',
        ]);

        $computer = \App\Models\Computer::findOrFail($id);
        
        if ($computer->status === 'in_use') {
            return redirect()->route('dashboard')->with('error', 'PC sedang digunakan.');
        }

        $total_price = $computer->price_per_hour * $request->duration_hours;
        
        \App\Models\Booking::create([
            'computer_id' => $computer->id,
            'customer_name' => $request->customer_name,
            'duration_hours' => $request->duration_hours,
            'start_time' => now(),
            'total_price' => $total_price,
            'end_time' => now()->addHours($request->duration_hours),
        ]);

        $computer->update(['status' => 'in_use']);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil untuk ' . $request->customer_name);
    }

    public function finish($id)
    {
        $computer = \App\Models\Computer::findOrFail($id);
        
        // Asumsi menyelesaikan pemakaian lebih awal atau pas
        $computer->update(['status' => 'available']);

        return redirect()->route('dashboard')->with('success', 'Sesi ' . $computer->name . ' telah diselesaikan.');
    }
}
