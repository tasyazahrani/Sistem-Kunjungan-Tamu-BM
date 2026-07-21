<?php
// database/migrations/xxxx_xx_xx_create_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // kunjungan_baru, verifikasi, menunggu, selesai, peringatan, rating
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable();
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['user_id', 'is_read']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};