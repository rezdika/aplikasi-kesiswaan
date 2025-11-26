<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;

class NotificationHelper
{
    public static function pelanggaranBaru($pelanggaran)
    {
        $siswa = $pelanggaran->siswa;
        $jenisPelanggaran = $pelanggaran->jenisPelanggaran;
        
        self::sendToLevel('kesiswaan', [
            'type' => 'pelanggaran',
            'title' => 'Pelanggaran Baru Perlu Verifikasi',
            'message' => "Siswa {$siswa->nama_siswa} melakukan {$jenisPelanggaran->nama}",
            'url' => route('kesiswaan.verifikasi.index')
        ]);

        self::sendToLevel('admin', [
            'type' => 'pelanggaran',
            'title' => 'Pelanggaran Baru',
            'message' => "Siswa {$siswa->nama_siswa} melakukan {$jenisPelanggaran->nama}",
            'url' => route('admin.pelanggaran')
        ]);

        self::sendToLevel('kepsek', [
            'type' => 'pelanggaran',
            'title' => 'Pelanggaran Baru',
            'message' => "Siswa {$siswa->nama_siswa} melakukan {$jenisPelanggaran->nama}",
            'url' => route('kepsek.dashboard')
        ]);

        self::sendToLevel('bk', [
            'type' => 'pelanggaran',
            'title' => 'Pelanggaran Baru - Perlu Konseling',
            'message' => "Siswa {$siswa->nama_siswa} melakukan {$jenisPelanggaran->nama}",
            'url' => route('bk.dashboard')
        ]);

        if ($siswa->kelas && $siswa->kelas->guru_id) {
            $waliKelas = User::where('guru_id', $siswa->kelas->guru_id)->where('level', 'wali_kelas')->first();
            if ($waliKelas) {
                self::sendToUser($waliKelas->id, [
                    'type' => 'pelanggaran',
                    'title' => 'Pelanggaran Siswa Kelas Anda',
                    'message' => "Siswa {$siswa->nama_siswa} melakukan {$jenisPelanggaran->nama}",
                    'url' => route('walas.pelanggaran.index')
                ]);
            }
        }

        $orangtua = $siswa->orangtua()->first();
        if ($orangtua && $orangtua->user_id) {
            self::sendToUser($orangtua->user_id, [
                'type' => 'pelanggaran',
                'title' => 'Pelanggaran Anak Anda',
                'message' => "Anak Anda {$siswa->nama_siswa} melakukan {$jenisPelanggaran->nama}",
                'url' => route('ortu.dashboard')
            ]);
        }

        $userSiswa = User::where('siswa_id', $siswa->id)->first();
        if ($userSiswa) {
            self::sendToUser($userSiswa->id, [
                'type' => 'pelanggaran',
                'title' => 'Pelanggaran Tercatat',
                'message' => "Anda tercatat melakukan {$jenisPelanggaran->nama}",
                'url' => route('siswa.dashboard')
            ]);
        }
    }

    public static function prestasiBaru($prestasi)
    {
        $siswa = $prestasi->siswa;
        $jenisPrestasi = $prestasi->jenisPrestasi;
        
        self::sendToLevel('kesiswaan', [
            'type' => 'prestasi',
            'title' => 'Prestasi Baru Perlu Verifikasi',
            'message' => "Siswa {$siswa->nama_siswa} meraih {$jenisPrestasi->nama}",
            'url' => route('kesiswaan.verifikasi.index')
        ]);

        self::sendToLevel('admin', [
            'type' => 'prestasi',
            'title' => 'Prestasi Baru',
            'message' => "Siswa {$siswa->nama_siswa} meraih {$jenisPrestasi->nama}",
            'url' => route('admin.prestasi')
        ]);

        self::sendToLevel('kepsek', [
            'type' => 'prestasi',
            'title' => 'Prestasi Siswa Baru',
            'message' => "Siswa {$siswa->nama_siswa} meraih {$jenisPrestasi->nama}",
            'url' => route('kepsek.dashboard')
        ]);

        $orangtua = $siswa->orangtua()->first();
        if ($orangtua && $orangtua->user_id) {
            self::sendToUser($orangtua->user_id, [
                'type' => 'prestasi',
                'title' => 'Prestasi Anak Anda',
                'message' => "Anak Anda {$siswa->nama_siswa} meraih {$jenisPrestasi->nama}",
                'url' => route('ortu.dashboard')
            ]);
        }

        $userSiswa = User::where('siswa_id', $siswa->id)->first();
        if ($userSiswa) {
            self::sendToUser($userSiswa->id, [
                'type' => 'prestasi',
                'title' => 'Prestasi Tercatat',
                'message' => "Prestasi Anda {$jenisPrestasi->nama} telah tercatat",
                'url' => route('siswa.dashboard')
            ]);
        }
    }

    public static function dataVerifikasi($data, $type, $status)
    {
        $siswa = $data->siswa;
        $statusText = $status ? 'disetujui' : 'ditolak';
        
        if ($data->guru_id) {
            $guru = User::find($data->guru_id);
            $url = $guru->level == 'guru' ? route('guru.dashboard') : route('walas.dashboard');
            self::sendToUser($data->guru_id, [
                'type' => 'verifikasi',
                'title' => ucfirst($type) . ' ' . ucfirst($statusText),
                'message' => ucfirst($type) . " siswa {$siswa->nama_siswa} telah {$statusText}",
                'url' => $url
            ]);
        }

        $userSiswa = User::where('siswa_id', $siswa->id)->first();
        if ($userSiswa) {
            self::sendToUser($userSiswa->id, [
                'type' => 'verifikasi',
                'title' => ucfirst($type) . ' ' . ucfirst($statusText),
                'message' => ucfirst($type) . " Anda telah {$statusText}",
                'url' => route('siswa.dashboard')
            ]);
        }

        $orangtua = $siswa->orangtua()->first();
        if ($orangtua && $orangtua->user_id) {
            self::sendToUser($orangtua->user_id, [
                'type' => 'verifikasi',
                'title' => ucfirst($type) . ' Anak ' . ucfirst($statusText),
                'message' => ucfirst($type) . " anak Anda {$siswa->nama_siswa} telah {$statusText}",
                'url' => route('ortu.dashboard')
            ]);
        }
    }

    public static function saksiBaru($sanksi)
    {
        $pelanggaran = $sanksi->pelanggaran;
        $siswa = $pelanggaran->siswa;
        
        $userSiswa = User::where('siswa_id', $siswa->id)->first();
        if ($userSiswa) {
            self::sendToUser($userSiswa->id, [
                'type' => 'sanksi',
                'title' => 'Sanksi Baru',
                'message' => "Anda mendapat sanksi: {$sanksi->jenis_sanksi}",
                'url' => route('siswa.pelaksanaan-sanksi.index')
            ]);
        }

        $orangtua = $siswa->orangtua()->first();
        if ($orangtua && $orangtua->user_id) {
            self::sendToUser($orangtua->user_id, [
                'type' => 'sanksi',
                'title' => 'Sanksi untuk Anak Anda',
                'message' => "Anak Anda {$siswa->nama_siswa} mendapat sanksi: {$sanksi->jenis_sanksi}",
                'url' => route('ortu.pelaksanaan-sanksi.index')
            ]);
        }

        if ($siswa->kelas && $siswa->kelas->guru_id) {
            $waliKelas = User::where('guru_id', $siswa->kelas->guru_id)->where('level', 'wali_kelas')->first();
            if ($waliKelas) {
                self::sendToUser($waliKelas->id, [
                    'type' => 'sanksi',
                    'title' => 'Sanksi Siswa Kelas Anda',
                    'message' => "Siswa {$siswa->nama_siswa} mendapat sanksi: {$sanksi->jenis_sanksi}",
                    'url' => route('walas.dashboard')
                ]);
            }
        }
    }

    public static function pelaksanaanSanksi($pelaksanaan)
    {
        $sanksi = $pelaksanaan->sanksi;
        $siswa = $sanksi->pelanggaran->siswa;
        
        self::sendToLevel('kesiswaan', [
            'type' => 'sanksi',
            'title' => 'Update Pelaksanaan Sanksi',
            'message' => "Siswa {$siswa->nama_siswa} update status sanksi: {$pelaksanaan->status}",
            'url' => route('kesiswaan.pelaksanaan-sanksi.index')
        ]);

        self::sendToLevel('admin', [
            'type' => 'sanksi',
            'title' => 'Update Pelaksanaan Sanksi',
            'message' => "Siswa {$siswa->nama_siswa} update status sanksi: {$pelaksanaan->status}",
            'url' => route('admin.sanksi')
        ]);
    }
    
    public static function sanksiDiperbarui($sanksi)
    {
        $pelanggaran = $sanksi->pelanggaran;
        $siswa = $pelanggaran->siswa;
        $jenisSanksi = $sanksi->jenisSanksi;
        
        // Notifikasi ke wali kelas
        if ($siswa->kelas && $siswa->kelas->guru_id) {
            $waliKelas = User::where('guru_id', $siswa->kelas->guru_id)->where('level', 'wali_kelas')->first();
            if ($waliKelas) {
                self::sendToUser($waliKelas->id, [
                    'type' => 'sanksi',
                    'title' => 'Sanksi Siswa Diperbarui',
                    'message' => "Sanksi siswa {$siswa->nama_siswa} diperbarui menjadi: {$jenisSanksi->nama_sanksi} karena pelanggaran baru",
                    'url' => route('walas.pelaksanaan-sanksi.index')
                ]);
            }
        }
        
        // Notifikasi ke kesiswaan
        self::sendToLevel('kesiswaan', [
            'type' => 'sanksi',
            'title' => 'Sanksi Otomatis Diperbarui',
            'message' => "Sanksi siswa {$siswa->nama_siswa} otomatis diperbarui karena pelanggaran baru",
            'url' => route('kesiswaan.sanksi.index')
        ]);
        
        // Notifikasi ke orangtua
        $orangtua = $siswa->orangtua()->first();
        if ($orangtua && $orangtua->user_id) {
            self::sendToUser($orangtua->user_id, [
                'type' => 'sanksi',
                'title' => 'Sanksi Anak Diperbarui',
                'message' => "Sanksi anak Anda {$siswa->nama_siswa} diperbarui menjadi: {$jenisSanksi->nama_sanksi}",
                'url' => route('ortu.pelaksanaan-sanksi.index')
            ]);
        }
        
        // Notifikasi ke siswa
        $userSiswa = User::where('siswa_id', $siswa->id)->first();
        if ($userSiswa) {
            self::sendToUser($userSiswa->id, [
                'type' => 'sanksi',
                'title' => 'Sanksi Anda Diperbarui',
                'message' => "Sanksi Anda diperbarui menjadi: {$jenisSanksi->nama_sanksi} karena pelanggaran baru",
                'url' => route('siswa.pelaksanaan-sanksi.index')
            ]);
        }
    }

    public static function bkBaru($bk)
    {
        $pelanggaran = $bk->pelanggaran;
        $siswa = $pelanggaran->siswa;
        
        $userSiswa = User::where('siswa_id', $siswa->id)->first();
        if ($userSiswa) {
            self::sendToUser($userSiswa->id, [
                'type' => 'bk',
                'title' => 'Panggilan Bimbingan Konseling',
                'message' => "Anda dijadwalkan untuk bimbingan konseling",
                'url' => route('siswa.dashboard')
            ]);
        }

        $orangtua = $siswa->orangtua()->first();
        if ($orangtua && $orangtua->user_id) {
            self::sendToUser($orangtua->user_id, [
                'type' => 'bk',
                'title' => 'Bimbingan Konseling Anak',
                'message' => "Anak Anda {$siswa->nama_siswa} dijadwalkan untuk bimbingan konseling",
                'url' => route('ortu.dashboard')
            ]);
        }
    }

    private static function sendToLevel($level, $data)
    {
        $users = User::where('level', $level)->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $data['type'],
                'title' => $data['title'],
                'message' => $data['message'],
                'url' => $data['url'] ?? null,
            ]);
        }
    }

    private static function sendToUser($userId, $data)
    {
        Notification::create([
            'user_id' => $userId,
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'url' => $data['url'] ?? null,
        ]);
    }
}
