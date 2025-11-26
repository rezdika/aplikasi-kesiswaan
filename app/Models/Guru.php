<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'nama_guru',
        'bidang_studi',
        'status',
    ];

    // Accessor untuk nama
    public function getNamaAttribute()
    {
        return $this->nama_guru;
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }
}
