<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'jenis_prestasi_id',
        'tahun_ajaran_id',
        'tanggal_prestasi',
        'poin',
        'keterangan',
        'terverifikasi',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function jenisPrestasi()
    {
        return $this->belongsTo(JenisPrestasi::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiData::class, 'prestasi_id');
    }
}
