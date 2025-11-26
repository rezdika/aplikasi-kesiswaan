<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaksanaanSanksi extends Model
{
    protected $table = 'pelaksanaan_sanksi';

    protected $fillable = [
        'sanksi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'bukti',
        'catatan',
        'status',
    ];

    protected $attributes = [
        'status' => 'terjadwal',
    ];

    // Status options
    const STATUS_TERJADWAL = 'terjadwal';
    const STATUS_DIKERJAKAN = 'dikerjakan';
    const STATUS_TUNTAS = 'tuntas';
    const STATUS_TERLAMBAT = 'terlambat';
    const STATUS_PERPANJANGAN = 'perpanjangan';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_TERJADWAL => 'Terjadwal',
            self::STATUS_DIKERJAKAN => 'Dikerjakan',
            self::STATUS_TUNTAS => 'Tuntas',
            self::STATUS_TERLAMBAT => 'Terlambat',
            self::STATUS_PERPANJANGAN => 'Perpanjangan'
        ];
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class, 'sanksi_id');
    }
}
