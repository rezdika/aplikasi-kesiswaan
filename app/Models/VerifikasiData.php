<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiData extends Model
{
    protected $table = 'verifikasi_data';
    
    protected $fillable = [
        'pelanggaran_id',
        'prestasi_id',
        'siswa_id',
        'guru_id',
        'status',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }
}
