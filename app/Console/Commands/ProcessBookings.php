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

    protected $description = 'Reserved command — booking status is now managed manually by admin (check-in/check-out).';

    public function handle()
    {
        // All booking status transitions are now handled manually by admin:
        // booked → active (admin check-in)
        // active → completed (admin check-out)
        $this->info('No automatic processing needed. Bookings are managed manually by admin.');
    }
}
