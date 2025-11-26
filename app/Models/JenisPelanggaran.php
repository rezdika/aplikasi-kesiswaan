<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'poin',
        'kategori',
        'sanksi_rekomendasi',
    ];

    // Accessor untuk nama
    public function getNamaAttribute()
    {
        return $this->nama_pelanggaran;
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'jenis_pelanggaran_id');
    }
}
