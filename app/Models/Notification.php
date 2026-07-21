<?php
// app/Models/Notification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'link',
        'is_read',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk notifikasi belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk notifikasi sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    // Tandai sebagai sudah dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Tandai sebagai belum dibaca
    public function markAsUnread()
    {
        $this->update(['is_read' => false]);
    }

    // Warna berdasarkan tipe
    public function getColorAttribute()
    {
        return match($this->type) {
            'kunjungan_baru' => 'success',
            'verifikasi' => 'primary',
            'menunggu' => 'warning',
            'selesai' => 'success',
            'peringatan' => 'danger',
            'rating' => 'warning',
            default => 'secondary',
        };
    }

    // Icon berdasarkan tipe
    public function getIconAttribute()
    {
        return match($this->type) {
            'kunjungan_baru' => 'bi-person-plus',
            'verifikasi' => 'bi-check-circle',
            'menunggu' => 'bi-hourglass-split',
            'selesai' => 'bi-check-circle-fill',
            'peringatan' => 'bi-exclamation-triangle',
            'rating' => 'bi-star-fill',
            default => 'bi-bell',
        };
    }
}