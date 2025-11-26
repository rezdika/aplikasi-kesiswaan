<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas_id',
        'jenis_kelamin',
    ];

    // Accessor untuk nama
    public function getNamaAttribute()
    {
        return $this->nama_siswa;
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'siswa_id');
    }

    public function orangtua()
    {
        return $this->hasMany(Orangtua::class, 'siswa_id');
    }
}
