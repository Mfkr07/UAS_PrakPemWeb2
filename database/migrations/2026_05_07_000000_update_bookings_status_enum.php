<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing 'pending' records to 'booked'
        DB::table('bookings')->where('status', 'pending')->update(['status' => 'booked']);

        // For SQLite: recreate the column (SQLite doesn't support ALTER ENUM)
        // For MySQL/PostgreSQL: modify the enum
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('status')->default('booked')->change();
        });
    }

    public function down(): void
    {
        DB::table('bookings')->where('status', 'booked')->update(['status' => 'pending']);

        Schema::table('bookings', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
};
