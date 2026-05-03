<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Pemilik',
            'email' => 'admin@warnet.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'wallet_balance' => 0,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Pelanggan Biasa',
            'email' => 'user@warnet.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'wallet_balance' => 50000,
        ]);

        \App\Models\CanteenItem::create([
            'name' => 'Indomie Telur',
            'price' => 10000,
            'image_path' => 'images/indomie.png',
        ]);

        \App\Models\CanteenItem::create([
            'name' => 'Kopi Susu',
            'price' => 12000,
            'image_path' => 'images/kopi_susu.png',
        ]);

        $this->call([
            ComputerSeeder::class,
        ]);
    }
}
