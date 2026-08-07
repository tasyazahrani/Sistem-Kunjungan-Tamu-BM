<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Menambahkan kolom pekerjaan dan jabatan tanpa menghapus data lama
            $table->string('pekerjaan')->nullable()->after('email');
            $table->string('jabatan')->nullable()->after('pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan', 'jabatan']);
        });
    }
};