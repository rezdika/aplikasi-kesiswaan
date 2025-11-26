<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    protected $table = 'bimbingan_konseling';
    
    protected $fillable = [
        'siswa_id',
        'bk_id',
        'pelanggaran_id',
        'tindakan',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function bk()
    {
        return $this->belongsTo(User::class, 'bk_id');
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }
}
