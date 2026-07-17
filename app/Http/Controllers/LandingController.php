<?php
// app/Http/Controllers/LandingController.php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Instansi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        try {
            // Cek koneksi database
            DB::connection()->getPdo();
            
            // Data statistik dengan fallback
            $totalKunjungan = Kunjungan::count() ?? 0;
            $totalInstansi = Instansi::count() ?? 0;
            $hariIni = Kunjungan::whereDate('waktu_kunjungan', Carbon::today())->count() ?? 0;
            $ratingRata = Kunjungan::whereNotNull('rating')->avg('rating') ?? 0; // <-- HANYA YANG ADA RATING

            // Data tren 7 hari terakhir
            $trenLanding = Kunjungan::selectRaw('DATE(waktu_kunjungan) as tanggal, COUNT(*) as jumlah')
                ->whereBetween('waktu_kunjungan', [Carbon::now()->subDays(7), Carbon::now()])
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'ASC')
                ->get();

            // Hitung persentase kenaikan
            $mingguIni = Kunjungan::whereBetween('waktu_kunjungan', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
            $mingguLalu = Kunjungan::whereBetween('waktu_kunjungan', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
            
            $persentaseNaik = 0;
            if ($mingguLalu > 0) {
                $persentaseNaik = round((($mingguIni - $mingguLalu) / $mingguLalu) * 100);
            } elseif ($mingguIni > 0) {
                $persentaseNaik = 100;
            }

            $rataRataHarian = $trenLanding->avg('jumlah') ?? 0;

        } catch (\Exception $e) {
            // Jika error, beri nilai default
            $totalKunjungan = 0;
            $totalInstansi = 0;
            $hariIni = 0;
            $ratingRata = 0;
            $trenLanding = collect([]);
            $persentaseNaik = 0;
            $rataRataHarian = 0;
        }

        $data = [
            'totalKunjungan' => $totalKunjungan,
            'totalInstansi' => $totalInstansi,
            'hariIni' => $hariIni,
            'ratingRata' => round($ratingRata, 1),
            'trenLanding' => $trenLanding,
            'persentaseNaik' => $persentaseNaik,
            'rataRataHarian' => round($rataRataHarian),
        ];

        return view('guest.landing', $data);
    }
}