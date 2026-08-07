<?php

namespace App\Http\Controllers;

use App\Exports\KunjunganExport;
use App\Models\Instansi;
use App\Models\Kunjungan;
use App\Models\TujuanKunjungan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'instansi_id', 'tujuan_kunjungan_id', 'status']);

        $kunjungans = Kunjungan::with(['instansi', 'tujuanKunjungan', 'bidang'])
            ->filter($filters)
            ->latest('waktu_kunjungan')
            ->paginate(20)
            ->withQueryString();

        $instansis = Instansi::orderBy('nama_instansi')->get();
        $tujuans = TujuanKunjungan::orderBy('nama_tujuan')->get();
        $statusList = Kunjungan::STATUS_LABELS;

        $ringkasan = [
            'total' => (clone $kunjungans->getCollection())->count(),
        ];

        return view('laporan.index', compact('kunjungans', 'instansis', 'tujuans', 'statusList', 'filters', 'ringkasan'));
    }

    public function pdf(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'instansi_id', 'tujuan_kunjungan_id', 'status']);

        // Mengambil data kunjungan beserta relasinya
        $kunjungans = Kunjungan::with(['instansi', 'tujuanKunjungan', 'bidang'])
            ->filter($filters)
            ->orderBy('waktu_kunjungan')
            ->get();

        // Load view PDF dengan data yang sudah diproses
        $pdf = Pdf::loadView('laporan.pdf', [
            'kunjungans' => $kunjungans,
            'filters' => $filters,
            'dicetakOleh' => auth()->user(),
            'tanggalCetak' => now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-kunjungan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function excel(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'instansi_id', 'tujuan_kunjungan_id', 'status']);

        return Excel::download(new KunjunganExport($filters), 'laporan-kunjungan-' . now()->format('Ymd-His') . '.xlsx');
    }
}