<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Kunjungan::whereDate('waktu_kunjungan', today())->count();
        $mingguIni = Kunjungan::whereBetween('waktu_kunjungan', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $bulanIni = Kunjungan::whereMonth('waktu_kunjungan', now()->month)->whereYear('waktu_kunjungan', now()->year)->count();
        $tahunIni = Kunjungan::whereYear('waktu_kunjungan', now()->year)->count();

        $menungguVerifikasi = Kunjungan::where('status', 'menunggu_verifikasi')->count();
        $sedangBerkunjung = Kunjungan::where('status', 'sedang_berkunjung')->count();

        // Tren 14 hari terakhir untuk grafik garis
        $trenHarian = collect(range(13, 0))->map(function ($i) {
            $tanggal = now()->subDays($i)->toDateString();
            return [
                'tanggal' => Carbon::parse($tanggal)->translatedFormat('d M'),
                'jumlah' => Kunjungan::whereDate('waktu_kunjungan', $tanggal)->count(),
            ];
        });

        // Statistik per instansi (top 8)
        $perInstansi = Kunjungan::selectRaw("COALESCE(instansis.nama_instansi, kunjungans.instansi_lainnya, 'Lainnya') as label, COUNT(*) as total")
            ->leftJoin('instansis', 'instansis.id', '=', 'kunjungans.instansi_id')
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Statistik per tujuan
        $perTujuan = Kunjungan::selectRaw("COALESCE(tujuan_kunjungans.nama_tujuan, kunjungans.tujuan_lainnya, 'Lainnya') as label, COUNT(*) as total")
            ->leftJoin('tujuan_kunjungans', 'tujuan_kunjungans.id', '=', 'kunjungans.tujuan_kunjungan_id')
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Statistik per bidang
        $perBidang = Kunjungan::selectRaw("COALESCE(bidangs.nama_bidang, 'Belum ditentukan') as label, COUNT(*) as total")
            ->leftJoin('bidangs', 'bidangs.id', '=', 'kunjungans.bidang_id')
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Statistik per status (untuk pie chart)
        $perStatus = Kunjungan::selectRaw('status, COUNT(*) as total')->groupBy('status')->get();

        $kunjunganTerbaru = Kunjungan::with(['instansi', 'tujuanKunjungan'])
            ->latest('waktu_kunjungan')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
            'hariIni', 'mingguIni', 'bulanIni', 'tahunIni',
            'menungguVerifikasi', 'sedangBerkunjung',
            'trenHarian', 'perInstansi', 'perTujuan', 'perBidang', 'perStatus',
            'kunjunganTerbaru'
        ));
    }
}
