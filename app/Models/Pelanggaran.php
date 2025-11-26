<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';
    
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'jenis_pelanggaran_id',
        'tahun_ajaran_id',
        'tanggal_pelanggaran',
        'poin',
        'keterangan',
        'terverifikasi',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function guruPencatat()
    {
        return $this->belongsTo(User::class, 'guru_id')->with('guru');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function sanksi()
    {
        return $this->hasMany(Sanksi::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiData::class, 'pelanggaran_id');
    }

    public function bimbinganKonseling()
    {
        return $this->hasOne(BimbinganKonseling::class);
    }

    public function monitoring()
    {
        return $this->hasOne(MonitoringPelanggaran::class, 'pelanggaran_id');
    }
}
