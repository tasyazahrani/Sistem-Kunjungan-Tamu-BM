<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    /**
     * Kirim notifikasi ke user tertentu
     */
    public static function send($userId, $type, $title, $message, $link = null, $data = [])
    {
        // Cek apakah user aktif
        $user = User::find($userId);
        if (!$user || !$user->isAktif()) {
            return null;
        }

        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'data' => $data,
        ]);
    }

    /**
     * Kirim notifikasi ke semua admin & petugas
     */
    public static function sendToStaff($type, $title, $message, $link = null, $data = [])
    {
        $users = User::whereIn('role', ['admin', 'petugas'])
            ->where('aktif', true)
            ->get();
        
        foreach ($users as $user) {
            self::send($user->id, $type, $title, $message, $link, $data);
        }
    }

    /**
     * Kirim notifikasi ke admin saja
     */
    public static function sendToAdmin($type, $title, $message, $link = null, $data = [])
    {
        $users = User::where('role', 'admin')
            ->where('aktif', true)
            ->get();
        
        foreach ($users as $user) {
            self::send($user->id, $type, $title, $message, $link, $data);
        }
    }

    /**
     * Kirim notifikasi kunjungan baru
     */
    public static function kunjunganBaru($kunjungan)
    {
        $title = 'Kunjungan Baru';
        $message = $kunjungan->nama_tamu . ' telah mengisi buku tamu.';
        $link = route('kunjungan.show', $kunjungan);
        $data = [
            'kunjungan_id' => $kunjungan->id,
            'nama_tamu' => $kunjungan->nama_tamu,
        ];

        self::sendToStaff('kunjungan_baru', $title, $message, $link, $data);
    }

    /**
     * Kirim notifikasi perubahan status
     */
    public static function statusBerubah($kunjungan, $oldStatus, $newStatus)
    {
        $title = 'Status Kunjungan Berubah';
        $message = "Kunjungan {$kunjungan->nama_tamu} berubah dari " . 
                   $oldStatus . " menjadi " . $newStatus;
        $link = route('kunjungan.show', $kunjungan);
        $data = [
            'kunjungan_id' => $kunjungan->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ];

        self::sendToStaff('verifikasi', $title, $message, $link, $data);
    }

    /**
     * Kirim notifikasi menunggu verifikasi
     */
    public static function menungguVerifikasi($jumlah)
    {
        $title = 'Menunggu Verifikasi';
        $message = "Ada {$jumlah} kunjungan yang menunggu verifikasi.";
        $link = route('kunjungan.index');

        self::sendToStaff('menunggu', $title, $message, $link, ['jumlah' => $jumlah]);
    }

    /**
     * Kirim notifikasi kunjungan selesai
     */
    public static function kunjunganSelesai($kunjungan)
    {
        $title = 'Kunjungan Selesai';
        $message = "Kunjungan {$kunjungan->nama_tamu} telah selesai.";
        $link = route('kunjungan.show', $kunjungan);
        $data = [
            'kunjungan_id' => $kunjungan->id,
        ];

        self::sendToStaff('selesai', $title, $message, $link, $data);
    }

    /**
     * Kirim notifikasi rating baru
     */
    public static function ratingBaru($kunjungan)
    {
        $title = 'Rating Baru';
        $message = "{$kunjungan->nama_tamu} memberikan rating " . 
                   str_repeat('⭐', $kunjungan->rating) . " ({$kunjungan->rating}/5)";
        $link = route('kunjungan.show', $kunjungan);
        $data = [
            'kunjungan_id' => $kunjungan->id,
            'rating' => $kunjungan->rating,
        ];

        self::sendToStaff('rating', $title, $message, $link, $data);
    }
}