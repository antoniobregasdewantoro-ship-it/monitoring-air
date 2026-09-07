<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SensorDataSeeder::class,
            // Jika nanti ada UserSeeder, tinggal tambahkan di sini
        ]);
    }
}