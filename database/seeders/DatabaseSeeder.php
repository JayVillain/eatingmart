<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder untuk Admin terlebih dahulu
        $this->call(AdminUserSeeder::class);

        // Buat 10 pengguna (pelanggan) menggunakan factory
        User::factory(10)->create();

        // Buat 20 menu item menggunakan factory
        Menu::factory(20)->create();
    }
}