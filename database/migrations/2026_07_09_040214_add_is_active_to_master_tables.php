<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan ke tabel instansis
        Schema::table('instansis', function (Blueprint $table) {
            if (!Schema::hasColumn('instansis', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        // Tambahkan ke tabel tujuan_kunjungans
        Schema::table('tujuan_kunjungans', function (Blueprint $table) {
            if (!Schema::hasColumn('tujuan_kunjungans', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        // Tambahkan ke tabel bidangs
        Schema::table('bidangs', function (Blueprint $table) {
            if (!Schema::hasColumn('bidangs', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('instansis', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('tujuan_kunjungans', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
        Schema::table('bidangs', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};