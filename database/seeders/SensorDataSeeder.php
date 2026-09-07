<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensor;
use Carbon\Carbon;

class SensorDataSeeder extends Seeder
{
    public function run(): void
    {
        Sensor::truncate();

        $now = Carbon::now();

        // Variasi parameter agar menghasilkan skor Fuzzy bervariasi
        $samples = [
            ['ph' => 7.5, 'suhu' => 28.5, 'tds' => 270, 'kekeruhan' => 12.0], // Normal
            ['ph' => 7.8, 'suhu' => 29.0, 'tds' => 310, 'kekeruhan' => 15.0], // Normal
            ['ph' => 6.2, 'suhu' => 32.5, 'tds' => 520, 'kekeruhan' => 28.0], // Warning
            ['ph' => 8.1, 'suhu' => 29.2, 'tds' => 290, 'kekeruhan' => 18.0], // Normal
            ['ph' => 5.2, 'suhu' => 35.0, 'tds' => 850, 'kekeruhan' => 45.0], // Critical
            ['ph' => 7.4, 'suhu' => 28.0, 'tds' => 280, 'kekeruhan' => 10.0], // Normal
            ['ph' => 6.0, 'suhu' => 33.0, 'tds' => 600, 'kekeruhan' => 32.0], // Warning
            ['ph' => 4.8, 'suhu' => 36.2, 'tds' => 920, 'kekeruhan' => 50.0], // Critical
        ];

        $sampleCount = count($samples);

        // Buat 20 data mundur per 30 menit
        for ($i = 19; $i >= 0; $i--) {
            $data = $samples[$i % $sampleCount];
            
            Sensor::create([
                'ph'        => $data['ph'],
                'suhu'      => $data['suhu'],
                'tds'       => $data['tds'],
                'kekeruhan' => $data['kekeruhan'],
                'created_at'=> $now->copy()->subMinutes(30 * $i),
                'updated_at'=> $now->copy()->subMinutes(30 * $i),
            ]);
        }
    }
}