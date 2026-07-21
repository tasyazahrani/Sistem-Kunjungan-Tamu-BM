<?php

namespace App\Models;

use App\Helpers\NotificationHelper;
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
        'rating',
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
        'rating' => 'integer',
    ];

    // ============================================
    // STATUS CONSTANTS
    // ============================================
    public const STATUS_LABELS = [
        'pending' => 'Menunggu Verifikasi',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'disetujui' => 'Disetujui',
        'sedang_berkunjung' => 'Sedang Berkunjung',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
        'verified' => 'Terverifikasi',
        'rejected' => 'Ditolak',
    ];

    public const STATUS_COLORS = [
        'pending' => 'warning',
        'menunggu_verifikasi' => 'warning',
        'disetujui' => 'info',
        'sedang_berkunjung' => 'primary',
        'selesai' => 'success',
        'ditolak' => 'danger',
        'verified' => 'success',
        'rejected' => 'danger',
    ];

    // Status yang bisa diedit
    public const EDITABLE_STATUSES = ['pending', 'menunggu_verifikasi'];

    // Status yang bisa diverifikasi
    public const VERIFIABLE_STATUSES = ['pending', 'menunggu_verifikasi'];

    // Status yang bisa dihapus
    public const DELETABLE_STATUSES = ['pending', 'menunggu_verifikasi', 'ditolak', 'rejected'];

    // ============================================
    // BOOT METHOD
    // ============================================
    protected static function booted(): void
    {
        static::creating(function (Kunjungan $kunjungan) {
            // Generate kode kunjungan
            if (empty($kunjungan->kode_kunjungan)) {
                $kunjungan->kode_kunjungan = 'KJG-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
            }
            
            // Set waktu kunjungan
            if (empty($kunjungan->waktu_kunjungan)) {
                $kunjungan->waktu_kunjungan = now();
            }
            
            // Set default status
            if (empty($kunjungan->status)) {
                $kunjungan->status = 'pending';
            }
            
            // Set default rating
            if (!isset($kunjungan->rating)) {
                $kunjungan->rating = null;
            }
        });

        static::created(function (Kunjungan $kunjungan) {
            // Trigger notifikasi kunjungan baru
            NotificationHelper::kunjunganBaru($kunjungan);
        });

        static::updating(function (Kunjungan $kunjungan) {
            // Jika status berubah menjadi selesai dan rating null, set default 5
            if ($kunjungan->status === 'selesai' && is_null($kunjungan->rating)) {
                $kunjungan->rating = 5;
            }
        });

        static::updated(function (Kunjungan $kunjungan) {
            // Trigger notifikasi perubahan status
            if ($kunjungan->wasChanged('status')) {
                $oldStatus = $kunjungan->getOriginal('status') ?? 'pending';
                $newStatus = $kunjungan->status;
                
                $oldLabel = self::STATUS_LABELS[$oldStatus] ?? $oldStatus;
                $newLabel = self::STATUS_LABELS[$newStatus] ?? $newStatus;

                NotificationHelper::statusBerubah($kunjungan, $oldLabel, $newLabel);

                // Jika status menjadi selesai
                if ($newStatus === 'selesai') {
                    NotificationHelper::kunjunganSelesai($kunjungan);
                }
            }

            // Trigger notifikasi rating baru
            if ($kunjungan->wasChanged('rating') && !is_null($kunjungan->rating)) {
                NotificationHelper::ratingBaru($kunjungan);
            }
        });

        static::deleted(function (Kunjungan $kunjungan) {
            // Hapus notifikasi terkait jika diperlukan
            // Notification::where('data->kunjungan_id', $kunjungan->id)->delete();
        });
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================
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

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * Status Label dengan fallback
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Status Color dengan fallback
     */
    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    /**
     * Nama Instansi
     */
    public function getNamaInstansiAttribute(): string
    {
        return $this->instansi->nama_instansi ?? ($this->instansi_lainnya ?: '-');
    }

    /**
     * Nama Tujuan
     */
    public function getNamaTujuanAttribute(): string
    {
        return $this->tujuanKunjungan->nama_tujuan ?? ($this->tujuan_lainnya ?: '-');
    }

    /**
     * Nama Bidang
     */
    public function getNamaBidangAttribute(): string
    {
        return $this->bidang->nama_bidang ?? '-';
    }

    /**
     * Rating dengan bintang
     */
    public function getRatingStarsAttribute(): string
    {
        if (is_null($this->rating) || $this->rating < 1 || $this->rating > 5) {
            return '';
        }
        
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= ($i <= $this->rating) ? '⭐' : '☆';
        }
        return $stars;
    }

    /**
     * Rating dalam persentase
     */
    public function getRatingPercentAttribute(): int
    {
        if (is_null($this->rating)) {
            return 0;
        }
        return round(($this->rating / 5) * 100);
    }

    /**
     * Waktu kunjungan formatted
     */
    public function getWaktuKunjunganFormattedAttribute(): string
    {
        return $this->waktu_kunjungan ? $this->waktu_kunjungan->format('d-m-Y H:i') : '-';
    }

    /**
     * Waktu verifikasi formatted
     */
    public function getWaktuVerifikasiFormattedAttribute(): string
    {
        return $this->waktu_verifikasi ? $this->waktu_verifikasi->format('d-m-Y H:i') : '-';
    }

    /**
     * Waktu selesai formatted
     */
    public function getWaktuSelesaiFormattedAttribute(): string
    {
        return $this->waktu_selesai ? $this->waktu_selesai->format('d-m-Y H:i') : '-';
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Data yang sudah diverifikasi (tidak pending)
     */
    public function scopeSudahDiverifikasi($query)
    {
        return $query->whereNotIn('status', ['pending', 'menunggu_verifikasi']);
    }

    /**
     * Data yang masih pending
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'menunggu_verifikasi']);
    }

    /**
     * Data yang sudah selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    /**
     * Data dengan rating tinggi (4-5)
     */
    public function scopeRatingTinggi($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Data dengan rating rendah (1-2)
     */
    public function scopeRatingRendah($query)
    {
        return $query->where('rating', '<=', 2);
    }

    /**
     * Data berdasarkan rentang tanggal
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu_kunjungan', [$startDate, $endDate]);
    }

    /**
     * Filter berdasarkan berbagai parameter
     */
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['tanggal_mulai'] ?? null, function ($q, $v) {
                return $q->whereDate('waktu_kunjungan', '>=', $v);
            })
            ->when($filters['tanggal_akhir'] ?? null, function ($q, $v) {
                return $q->whereDate('waktu_kunjungan', '<=', $v);
            })
            ->when($filters['instansi_id'] ?? null, function ($q, $v) {
                return $q->where('instansi_id', $v);
            })
            ->when($filters['tujuan_kunjungan_id'] ?? null, function ($q, $v) {
                return $q->where('tujuan_kunjungan_id', $v);
            })
            ->when($filters['status'] ?? null, function ($q, $v) {
                return $q->where('status', $v);
            })
            ->when($filters['bidang_id'] ?? null, function ($q, $v) {
                return $q->where('bidang_id', $v);
            })
            ->when($filters['rating'] ?? null, function ($q, $v) {
                return $q->where('rating', $v);
            })
            ->when($filters['cari'] ?? null, function ($q, $v) {
                return $q->where(function ($qq) use ($v) {
                    $qq->where('nama_tamu', 'like', "%{$v}%")
                        ->orWhere('kode_kunjungan', 'like', "%{$v}%")
                        ->orWhere('no_hp', 'like', "%{$v}%")
                        ->orWhere('email', 'like', "%{$v}%")
                        ->orWhere('keperluan', 'like', "%{$v}%")
                        ->orWhere('instansi_lainnya', 'like', "%{$v}%")
                        ->orWhere('tujuan_lainnya', 'like', "%{$v}%");
                });
            });
    }

    /**
     * Scope untuk laporan berdasarkan rentang tanggal
     */
    public function scopeForLaporan($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu_kunjungan', [$startDate, $endDate]);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Cek apakah kunjungan bisa diedit
     */
    public function getCanEditAttribute(): bool
    {
        return in_array($this->status, self::EDITABLE_STATUSES);
    }

    /**
     * Cek apakah kunjungan bisa diverifikasi
     */
    public function getCanVerifyAttribute(): bool
    {
        return in_array($this->status, self::VERIFIABLE_STATUSES);
    }

    /**
     * Cek apakah kunjungan bisa dihapus
     */
    public function getCanDeleteAttribute(): bool
    {
        return in_array($this->status, self::DELETABLE_STATUSES);
    }

    /**
     * Cek apakah kunjungan bisa diberi rating
     */
    public function getCanRateAttribute(): bool
    {
        return $this->status === 'selesai' && is_null($this->rating);
    }

    /**
     * Cek apakah sudah diberi rating
     */
    public function getHasRatingAttribute(): bool
    {
        return !is_null($this->rating) && $this->rating >= 1 && $this->rating <= 5;
    }

    /**
     * Verifikasi kunjungan
     */
    public function verify($userId, $status = 'disetujui')
    {
        $this->update([
            'status' => $status,
            'diverifikasi_oleh' => $userId,
            'waktu_verifikasi' => now(),
        ]);
    }

    /**
     * Selesaikan kunjungan
     */
    public function complete()
    {
        $this->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);
    }

    /**
     * Batalkan kunjungan
     */
    public function cancel()
    {
        $this->update([
            'status' => 'ditolak',
        ]);
    }

    /**
     * Beri rating
     */
    public function rate($rating)
    {
        $this->update([
            'rating' => $rating,
        ]);
    }

    // ============================================
    // STATISTICS HELPERS
    // ============================================

    /**
     * Get average rating
     */
    public static function getAverageRating(): float
    {
        return round(static::whereNotNull('rating')->avg('rating') ?? 0, 1);
    }

    /**
     * Get total with rating
     */
    public static function getTotalWithRating(): int
    {
        return static::whereNotNull('rating')->count();
    }

    /**
     * Get rating distribution
     */
    public static function getRatingDistribution(): array
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = static::where('rating', $i)->count();
        }
        return $distribution;
    }

    /**
     * Get status distribution
     */
    public static function getStatusDistribution(): array
    {
        $distribution = [];
        foreach (array_keys(self::STATUS_LABELS) as $status) {
            $distribution[$status] = static::where('status', $status)->count();
        }
        return $distribution;
    }

    /**
     * Get daily statistics for chart
     */
    public static function getDailyStats($days = 14)
    {
        return static::selectRaw('DATE(waktu_kunjungan) as tanggal, COUNT(*) as jumlah')
            ->whereBetween('waktu_kunjungan', [now()->subDays($days), now()])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    /**
     * Get monthly statistics
     */
    public static function getMonthlyStats($year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        return static::selectRaw('DAY(waktu_kunjungan) as hari, COUNT(*) as jumlah')
            ->whereYear('waktu_kunjungan', $year)
            ->whereMonth('waktu_kunjungan', $month)
            ->groupBy('hari')
            ->orderBy('hari', 'asc')
            ->get();
    }
}