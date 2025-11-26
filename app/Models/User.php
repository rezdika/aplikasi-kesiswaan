<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'guru_id',
        'siswa_id',
        'ortu_id',
        'username',
        'password',
        'level',
        'can_verify',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'can_verify' => 'boolean',
        ];
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function orangtua()
    {
        return $this->hasOne(Orangtua::class, 'user_id');
    }

    public function orangtuaUser()
    {
        return $this->belongsTo(Orangtua::class, 'ortu_id', 'orangtua_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }

    public function getUnreadNotificationCountAttribute()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    public function getProfileDataAttribute()
    {
        switch($this->level) {
            case 'siswa':
                $this->load('siswa.kelas');
                return $this->siswa ? [
                    'nama' => $this->siswa->nama_siswa,
                    'identifier' => $this->siswa->nis,
                    'kelas' => $this->siswa->kelas->nama_kelas ?? '-',
                    'jenis_kelamin' => $this->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'
                ] : null;
            case 'guru':
            case 'bk':
            case 'wali_kelas':
                $this->load('guru');
                return $this->guru ? [
                    'nama' => $this->guru->nama_guru,
                    'identifier' => $this->guru->nip,
                    'bidang_studi' => $this->guru->bidang_studi,
                    'status' => $this->guru->status
                ] : null;
            case 'kesiswaan':
                return [
                    'nama' => 'Staff Kesiswaan',
                    'identifier' => $this->username,
                    'bidang_studi' => 'Kesiswaan',
                    'status' => 'Aktif'
                ];
            case 'kepsek':
                return [
                    'nama' => 'Kepala Sekolah',
                    'identifier' => $this->username,
                    'bidang_studi' => 'Kepala Sekolah',
                    'status' => 'Aktif'
                ];
            case 'ortu':
                $this->load(['orangtuaUser.siswa', 'orangtua.siswa']);
                $orangtua = $this->orangtuaUser ?: $this->orangtua;
                return $orangtua ? [
                    'nama' => $orangtua->nama_orangtua,
                    'hubungan' => $orangtua->hubungan,
                    'pekerjaan' => $orangtua->pekerjaan,
                    'no_telp' => $orangtua->no_telp,
                    'siswa' => $orangtua->siswa->nama_siswa ?? '-'
                ] : null;
            default:
                return [
                    'nama' => ucfirst($this->level),
                    'identifier' => $this->username
                ];
        }
    }
}
