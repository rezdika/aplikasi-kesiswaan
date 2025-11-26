<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $adminUsers = User::where('level', 'admin')->get();
        $kesiswaanUsers = User::where('level', 'kesiswaan')->get();
        $guruUsers = User::where('level', 'guru')->get();

        // Notifikasi untuk admin
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'pelanggaran',
                'title' => 'Pelanggaran Baru Perlu Perhatian',
                'message' => 'Terdapat pelanggaran baru yang perlu ditinjau dari siswa kelas X',
                'url' => route('admin.pelanggaran'),
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $admin->id,
                'type' => 'prestasi',
                'title' => 'Prestasi Siswa Baru',
                'message' => 'Siswa meraih juara 1 lomba matematika tingkat kabupaten',
                'url' => route('admin.prestasi'),
                'is_read' => false,
            ]);
        }

        // Notifikasi untuk kesiswaan
        foreach ($kesiswaanUsers as $kesiswaan) {
            Notification::create([
                'user_id' => $kesiswaan->id,
                'type' => 'verifikasi',
                'title' => 'Data Perlu Verifikasi',
                'message' => 'Terdapat 3 data pelanggaran yang menunggu verifikasi',
                'url' => route('kesiswaan.verifikasi.index'),
                'is_read' => false,
            ]);
        }

        // Notifikasi untuk guru
        foreach ($guruUsers as $guru) {
            Notification::create([
                'user_id' => $guru->id,
                'type' => 'verifikasi',
                'title' => 'Verifikasi Data Selesai',
                'message' => 'Data pelanggaran yang Anda input telah diverifikasi',
                'url' => route('guru.dashboard'),
                'is_read' => false,
            ]);
        }
    }
}