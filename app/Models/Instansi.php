<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $fillable = ['nama_instansi', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }
}
