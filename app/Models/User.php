<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'aktif' => 'boolean',
    ];

    // ROLE CHECK METHODS
    // Cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah petugas
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    // Cek apakah user adalah pimpinan
    public function isPimpinan(): bool
    {
        return $this->role === 'pimpinan';
    }

    // Cek apakah user aktif
    public function isAktif(): bool
    {
        return $this->aktif === true;
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    // RELATIONSHIPS
    // Relasi ke kunjungan yang diverifikasi oleh user
    public function kunjunganDiverifikasi()
    {
        return $this->hasMany(Kunjungan::class, 'diverifikasi_oleh');
    }

    // Relasi ke kunjungan yang diinput oleh user
    public function kunjunganDiinput()
    {
        return $this->hasMany(Kunjungan::class, 'diinput_oleh');
    }

    // Relasi ke notifikasi
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // NOTIFICATION HELPERS
    // Mendapatkan semua notifikasi belum dibaca
    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    // Mendapatkan jumlah notifikasi belum dibaca
    public function unreadNotificationsCount(): int
    {
        return $this->unreadNotifications()->count();
    }

    // Mendapatkan notifikasi terbaru dengan limit
    public function latestNotifications($limit = 10)
    {
        return $this->notifications()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllNotificationsAsRead(): void
    {
        $this->unreadNotifications()->update(['is_read' => true]);
    }

    // SCOPES
    // Scope untuk user yang aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Scope untuk user yang tidak aktif
    public function scopeTidakAktif($query)
    {
        return $query->where('aktif', false);
    }

    // Scope untuk user dengan role tertentu
    public function scopeRole($query, $role)
    {
        if (is_array($role)) {
            return $query->whereIn('role', $role);
        }
        return $query->where('role', $role);
    }

    // Scope untuk admin
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    // Scope untuk petugas
    public function scopePetugas($query)
    {
        return $query->where('role', 'petugas');
    }

    // Scope untuk pimpinan
    public function scopePimpinan($query)
    {
        return $query->where('role', 'pimpinan');
    }

    // Scope untuk user dengan akses staff (admin + petugas)
    public function scopeStaff($query)
    {
        return $query->whereIn('role', ['admin', 'petugas']);
    }

    //Accessor untuk role label
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'petugas' => 'Petugas',
            'pimpinan' => 'Pimpinan',
            default => ucfirst($this->role),
        };
    }

    // Accessor untuk role badge color
    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'danger',
            'petugas' => 'primary',
            'pimpinan' => 'success',
            default => 'secondary',
        };
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute(): string
    {
        if ($this->aktif) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-danger">Nonaktif</span>';
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute(): string
    {
        return $this->aktif ? 'Aktif' : 'Nonaktif';
    }

    // Accessor untuk nama lengkap dengan role
    public function getFullNameAttribute(): string
    {
        return $this->name . ' (' . $this->role_label . ')';
    }

    // Mendapatkan daftar role yang tersedia
    public static function getAvailableRoles(): array
    {
        return [
            'admin' => 'Administrator',
            'petugas' => 'Petugas',
            'pimpinan' => 'Pimpinan',
        ];
    }

    // Mendapatkan daftar role untuk filter
    public static function getRoleOptions(): array
    {
        return [
            '' => 'Semua Role',
            'admin' => 'Administrator',
            'petugas' => 'Petugas',
            'pimpinan' => 'Pimpinan',
        ];
    }
}