<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Kunjungan;
use App\Models\TujuanKunjungan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'instansi_id', 'tujuan_kunjungan_id', 'status', 'cari']);

        $kunjungans = Kunjungan::with(['instansi', 'tujuanKunjungan', 'bidang'])
            ->sudahDiverifikasi()
            ->filter($filters)
            ->latest('waktu_kunjungan')
            ->paginate(20)
            ->withQueryString();

        $instansis = Instansi::orderBy('nama_instansi')->get();
        $tujuans = TujuanKunjungan::orderBy('nama_tujuan')->get();
        $statusList = Kunjungan::STATUS_LABELS;

        return view('riwayat.index', compact('kunjungans', 'instansis', 'tujuans', 'statusList', 'filters'));
    }
}
