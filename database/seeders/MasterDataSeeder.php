<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\Instansi;
use App\Models\TujuanKunjungan;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $instansis = [
            'Pemerintah Kabupaten Bener Meriah',
            'Pemerintah Provinsi Aceh',
            'Instansi Vertikal (Kejaksaan/Kepolisian/TNI)',
            'BUMN / BUMD',
            'Perusahaan Swasta',
            'Organisasi Masyarakat / LSM',
            'Perguruan Tinggi',
            'Masyarakat Umum',
        ];
        foreach ($instansis as $nama) {
            Instansi::updateOrCreate(['nama_instansi' => $nama]);
        }

        $tujuans = [
            'Audiensi / Silaturahmi',
            'Koordinasi Program Kerja',
            'Konsultasi Administrasi',
            'Pengajuan Proposal / Bantuan',
            'Kerja Sama / MoU',
            'Kunjungan Kerja / Studi Banding',
            'Undangan Rapat',
            'Lainnya',
        ];
        foreach ($tujuans as $nama) {
            TujuanKunjungan::updateOrCreate(['nama_tujuan' => $nama]);
        }

        $bidangs = [
            'Bagian Pemerintahan',
            'Bagian Hukum',
            'Bagian Organisasi',
            'Bagian Ekonomi & Pembangunan',
            'Bagian Kesejahteraan Rakyat',
            'Bagian Umum & Perlengkapan',
            'Bagian Protokol & Komunikasi Pimpinan',
            'Sekretaris Daerah',
        ];
        foreach ($bidangs as $nama) {
            Bidang::updateOrCreate(['nama_bidang' => $nama]);
        }
    }
}
