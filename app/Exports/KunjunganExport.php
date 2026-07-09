<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KunjunganExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private array $filters = [])
    {
    }

    public function collection()
    {
        return Kunjungan::with(['instansi', 'tujuanKunjungan', 'bidang'])
            ->filter($this->filters)
            ->orderBy('waktu_kunjungan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Kunjungan',
            'Tanggal & Jam',
            'Nama Tamu',
            'No. HP',
            'Instansi Asal',
            'Jumlah Tamu',
            'Tujuan Kunjungan',
            'Bidang Dikunjungi',
            'Pejabat yang Dituju',
            'Keperluan',
            'Status',
            'Diverifikasi Oleh',
        ];
    }

    public function map($kunjungan): array
    {
        return [
            $kunjungan->kode_kunjungan,
            optional($kunjungan->waktu_kunjungan)->format('d-m-Y H:i'),
            $kunjungan->nama_tamu,
            $kunjungan->no_hp,
            $kunjungan->nama_instansi,
            $kunjungan->jumlah_tamu,
            $kunjungan->nama_tujuan,
            $kunjungan->bidang->nama_bidang ?? '-',
            $kunjungan->nama_pejabat_dituju ?: '-',
            $kunjungan->keperluan,
            $kunjungan->status_label,
            $kunjungan->petugasVerifikasi->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
