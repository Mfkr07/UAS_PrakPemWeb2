<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:process';

    protected $description = 'Process pending bookings to active and active to completed based on schedule';

    public function handle()
    {
        $now = now();

        // 1. Activate pending bookings that have reached their start time
        $pendingBookings = \App\Models\Booking::where('status', 'pending')
            ->where('start_time', '<=', $now)
            ->get();

        foreach ($pendingBookings as $booking) {
            $booking->update(['status' => 'active']);
            $booking->computer->update(['status' => 'in_use']);
            $this->info("Activated booking ID: {$booking->id}");
        }

        // 2. Complete active bookings that have reached their end time
        $activeBookings = \App\Models\Booking::where('status', 'active')
            ->where('end_time', '<=', $now)
            ->get();

        foreach ($activeBookings as $booking) {
            $booking->update(['status' => 'completed']);
            $booking->computer->update(['status' => 'available']);
            $this->info("Completed booking ID: {$booking->id}");
        }
    }
}
