<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupData extends Model
{
    protected $table = 'backup_data';
    
    protected $fillable = [
        'filename',
        'filepath',
        'type',
        'size',
        'backup_date',
    ];

    protected $casts = [
        'backup_date' => 'datetime',
    ];
}
