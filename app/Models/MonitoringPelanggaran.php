<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringPelanggaran extends Model
{
    protected $table = 'monitoring_pelanggaran';

    protected $fillable = [
        'pelanggaran_id',
        'kepsek_id',
        'catatan',
        'status',
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'pelanggaran_id');
    }

    public function kepsek()
    {
        return $this->belongsTo(User::class, 'kepsek_id');
    }
}
