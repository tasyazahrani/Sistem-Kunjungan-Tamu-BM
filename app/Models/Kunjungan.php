<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_kunjungan',
        'nama_tamu',
        'no_hp',
        'email',
        'instansi_id',
        'instansi_lainnya',
        'alamat_instansi',
        'jumlah_tamu',
        'tujuan_kunjungan_id',
        'tujuan_lainnya',
        'bidang_id',
        'nama_pejabat_dituju',
        'keperluan',
        'status',
        'catatan_petugas',
        'diverifikasi_oleh',
        'waktu_verifikasi',
        'waktu_selesai',
        'input_manual',
        'diinput_oleh',
        'waktu_kunjungan',
        'ip_pengirim',
    ];

    protected $casts = [
        'input_manual' => 'boolean',
        'waktu_kunjungan' => 'datetime',
        'waktu_verifikasi' => 'datetime',
        'waktu_selesai' => 'datetime',
        'jumlah_tamu' => 'integer',
    ];

    // STATUS yang digunakan di form guest adalah 'pending'
    public const STATUS_LABELS = [
        'pending' => 'Menunggu Verifikasi',  // Tambahkan 'pending'
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'disetujui' => 'Disetujui',
        'sedang_berkunjung' => 'Sedang Berkunjung',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        'verified' => 'Terverifikasi',      // Tambahkan 'verified'
        'rejected' => 'Ditolak',             // Tambahkan 'rejected'
    ];

    public const STATUS_COLORS = [
        'pending' => 'warning',              // Tambahkan 'pending'
        'menunggu_verifikasi' => 'warning',
        'disetujui' => 'info',
        'sedang_berkunjung' => 'primary',
        'selesai' => 'success',
        'ditolak' => 'danger',
        'verified' => 'success',             // Tambahkan 'verified'
        'rejected' => 'danger',              // Tambahkan 'rejected'
    ];

    protected static function booted(): void
    {
        static::creating(function (Kunjungan $kunjungan) {
            if (empty($kunjungan->kode_kunjungan)) {
                $kunjungan->kode_kunjungan = 'KJG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
            }
            if (empty($kunjungan->waktu_kunjungan)) {
                $kunjungan->waktu_kunjungan = now();
            }
            // Set default status jika belum diisi
            if (empty($kunjungan->status)) {
                $kunjungan->status = 'pending';
            }
        });
    }

    // Relasi
    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function tujuanKunjungan()
    {
        return $this->belongsTo(TujuanKunjungan::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function petugasVerifikasi()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function petugasInput()
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }

    // Accessor untuk status label (dengan fallback)
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    // Accessor untuk status color (dengan fallback)
    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    // Accessor untuk nama instansi
    public function getNamaInstansiAttribute(): string
    {
        return $this->instansi->nama_instansi ?? ($this->instansi_lainnya ?: '-');
    }

    // Accessor untuk nama tujuan
    public function getNamaTujuanAttribute(): string
    {
        return $this->tujuanKunjungan->nama_tujuan ?? ($this->tujuan_lainnya ?: '-');
    }

    // Accessor untuk nama bidang
    public function getNamaBidangAttribute(): string
    {
        return $this->bidang->nama_bidang ?? '-';
    }

    // Scope untuk data yang sudah diverifikasi
    public function scopeSudahDiverifikasi($query)
    {
        return $query->whereNotIn('status', ['pending', 'menunggu_verifikasi']);
    }

    // Scope untuk data yang masih pending
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'menunggu_verifikasi']);
    }

    // Scope untuk filter
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['tanggal_mulai'] ?? null, fn ($q, $v) => $q->whereDate('waktu_kunjungan', '>=', $v))
            ->when($filters['tanggal_akhir'] ?? null, fn ($q, $v) => $q->whereDate('waktu_kunjungan', '<=', $v))
            ->when($filters['instansi_id'] ?? null, fn ($q, $v) => $q->where('instansi_id', $v))
            ->when($filters['tujuan_kunjungan_id'] ?? null, fn ($q, $v) => $q->where('tujuan_kunjungan_id', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['bidang_id'] ?? null, fn ($q, $v) => $q->where('bidang_id', $v))
            ->when($filters['cari'] ?? null, function ($q, $v) {
                $q->where(function ($qq) use ($v) {
                    $qq->where('nama_tamu', 'like', "%{$v}%")
                        ->orWhere('kode_kunjungan', 'like', "%{$v}%")
                        ->orWhere('no_hp', 'like', "%{$v}%")
                        ->orWhere('email', 'like', "%{$v}%")
                        ->orWhere('keperluan', 'like', "%{$v}%");
                });
            });
    }

    // Scope untuk laporan
    public function scopeForLaporan($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu_kunjungan', [$startDate, $endDate]);
    }

    // Cek apakah kunjungan bisa diedit
    public function getCanEditAttribute(): bool
    {
        return in_array($this->status, ['pending', 'menunggu_verifikasi']);
    }

    // Cek apakah kunjungan bisa diverifikasi
    public function getCanVerifyAttribute(): bool
    {
        return in_array($this->status, ['pending', 'menunggu_verifikasi']);
    }

    // Cek apakah kunjungan bisa dihapus
    public function getCanDeleteAttribute(): bool
    {
        return in_array($this->status, ['pending', 'menunggu_verifikasi', 'ditolak', 'rejected']);
    }
}