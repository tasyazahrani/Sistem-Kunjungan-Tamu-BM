<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kunjungan')->unique();

            // Data tamu
            $table->string('nama_tamu');
            $table->string('no_hp', 30)->nullable();
            $table->string('email')->nullable();
            $table->foreignId('instansi_id')->nullable()->constrained('instansis')->nullOnDelete();
            $table->string('instansi_lainnya')->nullable(); // jika tidak ada di master
            $table->string('alamat_instansi')->nullable();
            $table->unsignedInteger('jumlah_tamu')->default(1);

            // Tujuan kunjungan
            $table->foreignId('tujuan_kunjungan_id')->nullable()->constrained('tujuan_kunjungans')->nullOnDelete();
            $table->string('tujuan_lainnya')->nullable();
            $table->foreignId('bidang_id')->nullable()->constrained('bidangs')->nullOnDelete();
            $table->string('nama_pejabat_dituju')->nullable();
            $table->text('keperluan')->nullable();

            // Status & alur verifikasi
            $table->enum('status', [
                'menunggu_verifikasi',
                'disetujui',
                'sedang_berkunjung',
                'selesai',
                'ditolak',
            ])->default('menunggu_verifikasi');
            $table->text('catatan_petugas')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_verifikasi')->nullable();
            $table->timestamp('waktu_selesai')->nullable();

            // Meta
            $table->boolean('input_manual')->default(false); // true jika diinput petugas
            $table->foreignId('diinput_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('waktu_kunjungan')->useCurrent(); // tanggal & jam kedatangan
            $table->string('ip_pengirim', 45)->nullable();

            $table->timestamps();

            $table->index(['status']);
            $table->index(['waktu_kunjungan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
