<?php
// database/migrations/2026_07_17_xxxxxx_add_rating_to_kunjungans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            if (!Schema::hasColumn('kunjungans', 'rating')) {
                $table->integer('rating')->nullable()->after('status')->comment('Rating 1-5');
            }
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            if (Schema::hasColumn('kunjungans', 'rating')) {
                $table->dropColumn('rating');
            }
        });
    }
};