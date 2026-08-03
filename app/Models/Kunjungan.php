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

    // STATUS CONSTANTS - TANPA DUPLIKAT
    // Status labels mapping - HANYA 5 STATUS UNIK
    public const STATUS_LABELS = [
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'disetujui' => 'Disetujui',
        'sedang_berkunjung' => 'Sedang Berkunjung',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    // Status colors mapping
    public const STATUS_COLORS = [
        'menunggu_verifikasi' => 'warning',
        'disetujui' => 'info',
        'sedang_berkunjung' => 'primary',
        'selesai' => 'success',
        'ditolak' => 'danger',
    ];

    // Status yang bisa diedit
    public const EDITABLE_STATUSES = ['menunggu_verifikasi'];

    // Status yang bisa diverifikasi
    public const VERIFIABLE_STATUSES = ['menunggu_verifikasi'];

    // Status yang bisa dihapus
    public const DELETABLE_STATUSES = ['menunggu_verifikasi', 'ditolak'];

    // BOOT METHOD
    protected static function booted(): void
    {
        static::creating(function (self $kunjungan) {
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
                $kunjungan->status = 'menunggu_verifikasi';
            }
        });

        static::created(function (self $kunjungan) {
            // Trigger notifikasi kunjungan baru
            NotificationHelper::kunjunganBaru($kunjungan);
        });

        static::updated(function (self $kunjungan) {
            // Trigger notifikasi perubahan status
            if ($kunjungan->wasChanged('status')) {
                $oldStatus = $kunjungan->getOriginal('status') ?? 'menunggu_verifikasi';
                $newStatus = $kunjungan->status;
                
                $oldLabel = self::STATUS_LABELS[$oldStatus] ?? $oldStatus;
                $newLabel = self::STATUS_LABELS[$newStatus] ?? $newStatus;

                NotificationHelper::statusBerubah($kunjungan, $oldLabel, $newLabel);

                // Jika status menjadi selesai
                if ($newStatus === 'selesai') {
                    NotificationHelper::kunjunganSelesai($kunjungan);
                }
            }
        });
    }

    // RELATIONSHIPS
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

    // ACCESSORS
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    public function getNamaInstansiAttribute(): string
    {
        return $this->instansi->nama_instansi ?? ($this->instansi_lainnya ?: '-');
    }

    public function getNamaTujuanAttribute(): string
    {
        return $this->tujuanKunjungan->nama_tujuan ?? ($this->tujuan_lainnya ?: '-');
    }

    public function getNamaBidangAttribute(): string
    {
        return $this->bidang->nama_bidang ?? '-';
    }

    public function getWaktuKunjunganFormattedAttribute(): string
    {
        return $this->waktu_kunjungan ? $this->waktu_kunjungan->format('d-m-Y H:i') : '-';
    }

    public function getWaktuVerifikasiFormattedAttribute(): string
    {
        return $this->waktu_verifikasi ? $this->waktu_verifikasi->format('d-m-Y H:i') : '-';
    }

    public function getWaktuSelesaiFormattedAttribute(): string
    {
        return $this->waktu_selesai ? $this->waktu_selesai->format('d-m-Y H:i') : '-';
    }

    // SCOPES
    public function scopeSudahDiverifikasi($query)
    {
        return $query->whereNotIn('status', ['menunggu_verifikasi']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'menunggu_verifikasi');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu_kunjungan', [$startDate, $endDate]);
    }

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

    public function scopeForLaporan($query, $startDate, $endDate)
    {
        return $query->whereBetween('waktu_kunjungan', [$startDate, $endDate]);
    }

    // HELPER METHODS
    public function getCanEditAttribute(): bool
    {
        return in_array($this->status, self::EDITABLE_STATUSES);
    }

    public function getCanVerifyAttribute(): bool
    {
        return in_array($this->status, self::VERIFIABLE_STATUSES);
    }

    public function getCanDeleteAttribute(): bool
    {
        return in_array($this->status, self::DELETABLE_STATUSES);
    }

    // Verify kunjungan
    public function verify($userId, $status = 'disetujui'): void
    {
        $this->update([
            'status' => $status,
            'diverifikasi_oleh' => $userId,
            'waktu_verifikasi' => now(),
        ]);
    }

    // Complete kunjungan
    public function complete(): void
    {
        $this->update([
            'status' => 'selesai',
            'waktu_selesai' => now(),
        ]);
    }

    // Cancel kunjungan
    public function cancel(): void
    {
        $this->update([
            'status' => 'ditolak',
        ]);
    }

    // STATISTICS HELPERS
    public static function getStatusDistribution(): array
    {
        $distribution = [];
        foreach (array_keys(self::STATUS_LABELS) as $status) {
            $distribution[$status] = static::where('status', $status)->count();
        }
        return $distribution;
    }

    public static function getDailyStats($days = 14)
    {
        return static::selectRaw('DATE(waktu_kunjungan) as tanggal, COUNT(*) as jumlah')
            ->whereBetween('waktu_kunjungan', [now()->subDays($days), now()])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();
    }

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