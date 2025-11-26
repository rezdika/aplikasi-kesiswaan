<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfirmasiSurat extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_surat';
    
    protected $fillable = [
        'pelanggaran_id',
        'siswa_id',
        'orangtua_id',
        'jenis_konfirmasi',
        'tanggal_konfirmasi',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_konfirmasi' => 'datetime'
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function orangtua()
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }
}