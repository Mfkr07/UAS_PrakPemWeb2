<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $name = 'PC-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $price = 5000;
            
            if ($i >= 6 && $i <= 8) {
                $name = 'VIP-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $price = 10000;
            } elseif ($i >= 9 && $i <= 10) {
                $name = 'VVIP-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $price = 25000;
            }

            \App\Models\Computer::create([
                'name' => $name,
                'status' => 'available',
                'price_per_hour' => $price,
            ]);
        }
    }
}
