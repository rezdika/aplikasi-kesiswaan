<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    protected $table = 'sanksi';

    protected $fillable = [
        'pelanggaran_id',
        'jenis_sanksi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan',
    ];

    // Status sanksi constants
    const STATUS_DIRENCANAKAN = 'direncanakan';
    const STATUS_BERJALAN = 'berjalan';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITUNDA = 'ditunda';
    const STATUS_DIBATALKAN = 'dibatalkan';

    protected $attributes = [
        'status' => 'direncanakan',
    ];

    public static function getStatusOptions()
    {
        return [
            self::STATUS_DIRENCANAKAN => 'Direncanakan',
            self::STATUS_BERJALAN => 'Berjalan',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITUNDA => 'Ditunda',
            self::STATUS_DIBATALKAN => 'Dibatalkan'
        ];
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    public function jenisSanksi()
    {
        return $this->belongsTo(JenisSanksi::class, 'jenis_sanksi_id');
    }

    public function pelaksanaanSanksi()
    {
        return $this->hasOne(PelaksanaanSanksi::class, 'sanksi_id');
    }

    public function pelaksanaan()
    {
        return $this->hasMany(PelaksanaanSanksi::class, 'sanksi_id');
    }
}
