<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Mengambil hingga 1440 data terakhir agar grafik 7 & 30 hari memiliki rentang tanggal yang cukup
        $sensorData = Sensor::orderBy('created_at', 'desc')->take(1440)->get();
        $cuaca = $this->getCuacaData();

        return view('dashboard', compact('sensorData', 'cuaca'));
    }

    public function getSensorData()
    {
        // PERBAIKAN: Mengambil data yang sama dengan index() agar pembaruan AJAX tidak memotong rentang grafik
        $sensorData = Sensor::orderBy('created_at', 'desc')->take(1440)->get();
        $latest = $sensorData->first();
        $quality = null;

        if ($latest) {
            $quality = round($this->calculateFuzzyQuality($latest->ph, $latest->suhu, $latest->tds ?? 0, $latest->kekeruhan), 2);
        }

        $sensorDataArray = $sensorData->toArray();
        if (isset($sensorDataArray[0])) {
            $sensorDataArray[0]['quality'] = $quality;
        }

        // Return Data Sensor DAN Data Cuaca untuk AJAX Polling Realtime
        return response()->json([
            'sensors' => $sensorDataArray,
            'cuaca'   => $this->getCuacaData()
        ]);
    }

    private function getCuacaData()
    {
        // Cek Cache
        if (Cache::has('bmkg_cuaca_jabon')) {
            return Cache::get('bmkg_cuaca_jabon');
        }

        try {
            // API BMKG Resmi (JSON) Khusus Kecamatan Jabon, Kabupaten Sidoarjo
            $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=35.15.05.2001";

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
                'Accept'     => 'application/json'
            ])->withoutVerifying()->timeout(10)->get($url);

            if ($response->successful()) {
                $data = $response->json();

                // BMKG JSON mengembalikan array cuaca per 3 jam
                $cuacaList = [];
                if (isset($data['data'][0]['cuaca'])) {
                    foreach ($data['data'][0]['cuaca'] as $group) {
                        if (is_array($group)) {
                            foreach ($group as $item) {
                                $cuacaList[] = $item;
                            }
                        } else {
                            $cuacaList[] = $group;
                        }
                    }
                } elseif (isset($data['data'])) {
                    $cuacaList = $data['data'];
                }

                if (!empty($cuacaList)) {
                    $now = Carbon::now('Asia/Jakarta');
                    $currentForecast = null;
                    $hourly = [];

                    foreach ($cuacaList as $item) {
                        $localTimeStr = $item['local_datetime'] ?? $item['datetime'] ?? null;
                        if (!$localTimeStr) continue;

                        $dt = Carbon::parse($localTimeStr, 'Asia/Jakarta');

                        $dataPoint = [
                            'carbon'     => $dt,
                            'temp'       => (string)($item['t'] ?? '30'),
                            'weather'    => $item['weather_desc'] ?? 'Cerah Berawan',
                            'humidity'   => (string)($item['hu'] ?? '75'),
                            'wind_speed' => (string)round((float)($item['ws'] ?? 10)),
                            'wind_dir'   => $this->convertWindDir($item['wd'] ?? 'TL'),
                        ];

                        if ($dt->lte($now)) {
                            $currentForecast = $dataPoint;
                        }

                        if ($dt->gte($now->copy()->subHours(2)) && count($hourly) < 5) {
                            $hourly[] = [
                                'jam'   => $dt->format('H:i'),
                                'suhu'  => $dataPoint['temp'] . '°',
                                'icon'  => $this->getWeatherIconText($dataPoint['weather'], $dt->format('H:i')),
                                'angin' => $dataPoint['wind_dir'],
                            ];
                        }
                    }

                    if (!$currentForecast && !empty($cuacaList)) {
                        $first = $cuacaList[0];
                        $currentForecast = [
                            'temp'       => (string)($first['t'] ?? '31'),
                            'weather'    => $first['weather_desc'] ?? 'Cerah Berawan',
                            'humidity'   => (string)($first['hu'] ?? '78'),
                            'wind_speed' => (string)round((float)($first['ws'] ?? 12)),
                            'wind_dir'   => $this->convertWindDir($first['wd'] ?? 'TL'),
                        ];
                    }

                    if ($currentForecast) {
                        $cuacaReal = [
                            'lokasi'     => 'JABON, SIDOARJO',
                            'hari'       => $now->translatedFormat('l'),
                            'waktu'      => $now->format('H:i') . ' WIB',
                            'suhu'       => $currentForecast['temp'],
                            'kondisi'    => $currentForecast['weather'],
                            'icon'       => $this->getWeatherIconText($currentForecast['weather'], $now->format('H:i')),
                            'kelembaban' => $currentForecast['humidity'],
                            'angin'      => $currentForecast['wind_speed'] . ' km/j',
                            'arah_angin' => $currentForecast['wind_dir'],
                            'hourly'     => $hourly
                        ];

                        Cache::put('bmkg_cuaca_jabon', $cuacaReal, 1800);
                        return $cuacaReal;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("BMKG API Error: " . $e->getMessage());
        }

        return $this->getOpenMeteoCuaca();
    }

    private function getWeatherIconText($desc, $jam = null)
    {
        $desc = strtolower($desc);

        $isNight = false;
        if ($jam) {
            $hour = (int) explode(':', $jam)[0];
            $isNight = ($hour >= 18 || $hour < 6);
        }

        if (str_contains($desc, 'petir')) {
            return 'fas fa-cloud-bolt text-warning';
        }

        if (str_contains($desc, 'hujan')) {
            return 'fas fa-cloud-showers-heavy text-primary';
        }

        if (str_contains($desc, 'kabut') || str_contains($desc, 'kabur')) {
            return 'fas fa-smog text-secondary';
        }

        if (str_contains($desc, 'berawan') && str_contains($desc, 'cerah')) {
            return $isNight ? 'fas fa-cloud-moon text-info' : 'fas fa-cloud-sun text-warning';
        }

        if (str_contains($desc, 'berawan')) {
            return 'fas fa-cloud text-secondary';
        }

        if (str_contains($desc, 'cerah')) {
            return $isNight ? 'fas fa-moon text-warning' : 'fas fa-sun text-warning';
        }

        return $isNight ? 'fas fa-moon text-warning' : 'fas fa-sun text-warning';
    }

    private function getOpenMeteoCuaca()
    {
        try {
            $url = "https://api.open-meteo.com/v1/forecast?latitude=-7.5622&longitude=112.7675&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,wind_direction_10m&hourly=temperature_2m,weather_code,wind_direction_10m&timezone=Asia%2FJakarta";
            $res = Http::timeout(5)->get($url);

            if ($res->successful()) {
                $data = $res->json();
                $now = Carbon::now('Asia/Jakarta');
                
                $hourly = [];
                if (isset($data['hourly']['time'])) {
                    foreach ($data['hourly']['time'] as $idx => $timeStr) {
                        $dt = Carbon::parse($timeStr, 'Asia/Jakarta');
                        if ($dt->gte($now->copy()->subHour()) && count($hourly) < 5) {
                            $hourly[] = [
                                'jam'   => $dt->format('H:i'),
                                'suhu'  => round($data['hourly']['temperature_2m'][$idx]) . '°',
                                'icon'  => $this->getWeatherIcon($data['hourly']['weather_code'][$idx] ?? 1),
                                'angin' => '↗ TL'
                            ];
                        }
                    }
                }

                $current = $data['current'] ?? [];
                return [
                    'lokasi'     => 'JABON, SIDOARJO',
                    'hari'       => $now->translatedFormat('l'),
                    'waktu'      => $now->format('H:i') . ' WIB',
                    'suhu'       => (string)round($current['temperature_2m'] ?? 31),
                    'kondisi'    => 'Cerah Berawan',
                    'icon'       => 'fas fa-cloud-sun text-warning',
                    'kelembaban' => (string)($current['relative_humidity_2m'] ?? 75),
                    'angin'      => round($current['wind_speed_10m'] ?? 10) . ' km/j',
                    'arah_angin' => '↗ TL',
                    'hourly'     => $hourly
                ];
            }
        } catch (\Exception $e) {
            \Log::error("OpenMeteo Error: " . $e->getMessage());
        }

        return $this->getDefaultCuaca();
    }

    public function checkWaterQuality()
    {
        $latestData = Sensor::latest()->first();

        if (!$latestData) {
            return response()->json(['status' => 'ok', 'message' => 'Belum ada data sensor.']);
        }

        $warnings = [];

        if ($latestData->ph < 7.5 || $latestData->ph > 8.5) {
            $warnings[] = "⚠️ pH tidak normal! Saat ini: {$latestData->ph}";
        }
        if ($latestData->suhu < 28 || $latestData->suhu > 32) {
            $warnings[] = "🔥 Suhu ekstrem! Saat ini: {$latestData->suhu}°C";
        }
        if ($latestData->tds > 1000) {
            $warnings[] = "⚡ TDS tinggi! Saat ini: {$latestData->tds} ppm";
        }
        if ($latestData->kekeruhan > 30) {
            $warnings[] = "💧 Kekeruhan tinggi! Saat ini: {$latestData->kekeruhan} NTU";
        }

        return !empty($warnings)
            ? response()->json(['status' => 'warning', 'messages' => $warnings])
            : response()->json(['status' => 'ok', 'message' => 'Semua parameter dalam kondisi normal.']);
    }

    public function checkWater()
    {
        $latest = Sensor::latest()->first();

        if (!$latest) {
            return response()->json(['status' => 'no_data', 'message' => 'Tidak ada data sensor.']);
        }

        $quality = $this->calculateFuzzyQuality($latest->ph, $latest->suhu, $latest->tds ?? 0, $latest->kekeruhan);
        $latest->kualitas = $quality;
        $saved = $latest->save();

        if (!$saved) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan ke database.']);
        }

        return response()->json([
            'status' => $quality < 50 ? 'warning' : 'normal',
            'quality' => round($quality, 2),
            'messages' => $quality < 50
                ? ['Kualitas air buruk. Segera cek kolam.']
                : ['Kualitas air dalam kondisi baik.']
        ]);
    }

    private function trapezoid($x, $a, $b, $c, $d)
    {
        if ($x <= $a || $x >= $d) return 0;
        elseif ($x >= $b && $x <= $c) return 1;
        elseif ($x > $a && $x < $b) return ($x - $a) / ($b - $a);
        elseif ($x > $c && $x < $d) return ($d - $x) / ($d - $c);
        return 0;
    }

    private function output_membership($x, $label)
    {
        switch ($label) {
            case 'buruk':
                return $this->trapezoid($x, 0, 0, 20, 40);
            case 'sedang':
                return $this->trapezoid($x, 35, 45, 55, 70);
            case 'baik':
                return $this->trapezoid($x, 70, 85, 100, 100);
            default:
                return 0;
        }
    }

    public function calculateFuzzyQuality($ph, $suhu, $tds, $ntu)
    {
        // 1. Fuzzifikasi pH (3 Variabel: Asam, Netral, Basa)
        $ph_asam   = $this->trapezoid($ph, 0, 0, 6.5, 7.5);
        $ph_netral = $this->trapezoid($ph, 7, 7.4, 8.4, 9);
        $ph_basa   = $this->trapezoid($ph, 8.5, 10, 14, 14);

        // 2. Fuzzifikasi Suhu (3 Variabel: Dingin, Optimal, Panas)
        $suhu_dingin  = $this->trapezoid($suhu, 0, 0, 25, 28);
        $suhu_optimal = $this->trapezoid($suhu, 26, 27, 31, 34);
        $suhu_panas   = $this->trapezoid($suhu, 32, 35, 45, 45);

        // 3. Fuzzifikasi TDS (3 Variabel: Normal, Sedang, Tinggi)
        $tds_normal = $this->trapezoid($tds, 0, 0, 500, 1000);
        $tds_sedang = $this->trapezoid($tds, 800, 1000, 1500, 2000);
        $tds_tinggi = $this->trapezoid($tds, 1800, 2000, 5000, 5000);

        // 4. Fuzzifikasi Kekeruhan (3 Variabel: Jernih, Optimal, Keruh)
        $keruh_jernih  = $this->trapezoid($ntu, 0, 0, 3, 5);
        $keruh_optimal = $this->trapezoid($ntu, 3, 4, 39, 43);
        $keruh_keruh   = $this->trapezoid($ntu, 40, 44, 100, 100);

        // Basis Aturan Fuzzy (pH, Suhu, Kekeruhan)
        $base_rules = [
            ['asam', 'dingin', 'jernih', 'buruk'],
            ['asam', 'dingin', 'optimal', 'buruk'],
            ['asam', 'dingin', 'keruh', 'buruk'],
            ['asam', 'optimal', 'jernih', 'baik'],
            ['asam', 'optimal', 'optimal', 'sedang'],
            ['asam', 'optimal', 'keruh', 'buruk'],
            ['asam', 'panas', 'jernih', 'buruk'],
            ['asam', 'panas', 'optimal', 'buruk'],
            ['asam', 'panas', 'keruh', 'buruk'],

            ['netral', 'dingin', 'jernih', 'baik'],
            ['netral', 'dingin', 'optimal', 'sedang'],
            ['netral', 'dingin', 'keruh', 'buruk'],
            ['netral', 'optimal', 'jernih', 'baik'],
            ['netral', 'optimal', 'optimal', 'baik'],
            ['netral', 'optimal', 'keruh', 'sedang'],
            ['netral', 'panas', 'jernih', 'baik'],
            ['netral', 'panas', 'optimal', 'sedang'],
            ['netral', 'panas', 'keruh', 'buruk'],

            ['basa', 'dingin', 'jernih', 'buruk'],
            ['basa', 'dingin', 'optimal', 'buruk'],
            ['basa', 'dingin', 'keruh', 'buruk'],
            ['basa', 'optimal', 'jernih', 'baik'],
            ['basa', 'optimal', 'optimal', 'baik'],
            ['basa', 'optimal', 'keruh', 'buruk'],
            ['basa', 'panas', 'jernih', 'buruk'],
            ['basa', 'panas', 'optimal', 'buruk'],
            ['basa', 'panas', 'keruh', 'buruk'],
        ];

        $rule_outputs = ['buruk' => 0, 'sedang' => 0, 'baik' => 0];

        // Evaluasi Aturan Terintegrasi 4 Sensor
        foreach ($base_rules as $rule) {
            [$ph_key, $suhu_key, $keruh_key, $output_label] = $rule;
            $mu_ph = ${"ph_" . $ph_key};
            $mu_suhu = ${"suhu_" . $suhu_key};
            $mu_keruh = ${"keruh_" . $keruh_key};

            // Kondisi 1: TDS Normal -> Menjaga kualitas dari aturan dasar
            $mu_normal = min($mu_ph, $mu_suhu, $mu_keruh, $tds_normal);
            $rule_outputs[$output_label] += $mu_normal;

            // Kondisi 2: TDS Sedang -> Menurunkan grade 1 tingkat (Baik -> Sedang, Sedang/Buruk -> Buruk)
            $mu_sedang = min($mu_ph, $mu_suhu, $mu_keruh, $tds_sedang);
            $sedang_label = ($output_label === 'baik') ? 'sedang' : 'buruk';
            $rule_outputs[$sedang_label] += $mu_sedang;

            // Kondisi 3: TDS Tinggi -> Kualitas air langsung dinilai Buruk
            $mu_tinggi = min($mu_ph, $mu_suhu, $mu_keruh, $tds_tinggi);
            $rule_outputs['buruk'] += $mu_tinggi;
        }

        // Defuzzifikasi Centroid (Center of Gravity)
        $numerator = 0;
        $denominator = 0;

        for ($x = 0; $x <= 100; $x += 0.1) {
            $mu_buruk  = min($rule_outputs['buruk'], $this->output_membership($x, 'buruk'));
            $mu_sedang = min($rule_outputs['sedang'], $this->output_membership($x, 'sedang'));
            $mu_baik   = min($rule_outputs['baik'], $this->output_membership($x, 'baik'));

            $mu_total = max($mu_buruk, $mu_sedang, $mu_baik);

            $numerator += $x * $mu_total;
            $denominator += $mu_total;
        }

        if ($denominator == 0) return 0;

        return round($numerator / $denominator, 2);
    }

    public function updateMissingQuality()
    {
        $sensors = Sensor::whereNull('kualitas')->get();
        $count = 0;

        foreach ($sensors as $sensor) {
            if ($sensor->ph && $sensor->suhu && $sensor->kekeruhan) {
                $this->updateSensorQuality($sensor);
                $count++;
            }
        }

        return response()->json([
            'message' => "Berhasil update kualitas untuk $count data yang sebelumnya null."
        ]);
    }

    private function updateSensorQuality($sensor)
    {
        $sensor->kualitas = $this->calculateFuzzyQuality($sensor->ph, $sensor->suhu, $sensor->tds ?? 0, $sensor->kekeruhan);
        $sensor->save();
    }

    private function getWeatherText($code) {
        $map = [
            '0' => 'Cerah', '1' => 'Cerah Berawan', '2' => 'Cerah Berawan',
            '3' => 'Berawan', '4' => 'Berawan Tebal', '60' => 'Hujan Ringan',
            '61' => 'Hujan Sedang', '63' => 'Hujan Lebat', '95' => 'Hujan Petir'
        ];
        return $map[(string)$code] ?? 'Cerah Berawan';
    }

    private function getWeatherIcon($code) {
        $code = (string)$code;
        if (in_array($code, ['0'])) return 'fas fa-sun text-warning';
        if (in_array($code, ['1', '2', '3'])) return 'fas fa-cloud-sun text-warning';
        if (in_array($code, ['4'])) return 'fas fa-cloud text-secondary';
        if (in_array($code, ['60', '61', '63'])) return 'fas fa-cloud-showers-heavy text-primary';
        if (in_array($code, ['95'])) return 'fas fa-cloud-bolt text-warning';
        return 'fas fa-cloud-sun text-warning';
    }

    private function convertWindDir($code) {
        $code = strtoupper(trim((string)$code));
        $map = [
            'N'  => '↑ U', 
            'NE' => '↗ TL', 
            'E'  => '→ T', 
            'SE' => '↘ TG', 
            'S'  => '↓ S', 
            'SW' => '↙ BD', 
            'W'  => '← B', 
            'NW' => '↖ BL'
        ];
        return $map[$code] ?? '↗ TL';
    }

    private function getDefaultCuaca() {
        $now = Carbon::now('Asia/Jakarta');
        return [
            'lokasi'     => 'JABON, SIDOARJO',
            'hari'       => $now->translatedFormat('l'),
            'waktu'      => $now->format('H:i') . ' WIB',
            'suhu'       => '31',
            'kondisi'    => 'Cerah Berawan',
            'icon'       => 'fas fa-cloud-sun text-warning',
            'kelembaban' => '78',
            'angin'      => '12 km/j',
            'arah_angin' => '↗ TL',
            'hourly'     => [
                ['jam' => '07:00', 'suhu' => '29°', 'icon' => 'fas fa-sun text-warning', 'angin' => '↗ TL'],
                ['jam' => '13:00', 'suhu' => '32°', 'icon' => 'fas fa-cloud-sun text-warning', 'angin' => '→ T'],
                ['jam' => '19:00', 'suhu' => '28°', 'icon' => 'fas fa-cloud-moon text-info', 'angin' => '↘ TG'],
                ['jam' => '01:00', 'suhu' => '26°', 'icon' => 'fas fa-moon text-warning', 'angin' => '↙ BD'],
            ]
        ];
    }
}