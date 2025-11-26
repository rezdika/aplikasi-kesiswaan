<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPrestasi extends Model
{
    protected $table = 'jenis_prestasi';

    protected $fillable = [
        'nama_prestasi',
        'poin',
        'kategori',
        'penghargaan',
    ];

    // Accessor untuk nama
    public function getNamaAttribute()
    {
        return $this->nama_prestasi;
    }
}
