<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_bidang', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }
}
