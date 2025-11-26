<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Orangtua;

class UserProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Update user siswa dengan siswa_id
        $userSiswa = User::where('level', 'siswa')->first();
        if ($userSiswa) {
            $siswa = Siswa::first();
            if ($siswa) {
                $userSiswa->update(['siswa_id' => $siswa->id]);
            }
        }

        // Update user guru dengan guru_id
        $userGuru = User::where('level', 'guru')->first();
        if ($userGuru) {
            $guru = Guru::first();
            if ($guru) {
                $userGuru->update(['guru_id' => $guru->id]);
            }
        }

        // Update user bk dengan guru_id
        $userBk = User::where('level', 'bk')->first();
        if ($userBk) {
            $guru = Guru::skip(1)->first();
            if ($guru) {
                $userBk->update(['guru_id' => $guru->id]);
            }
        }

        // Update user wali_kelas dengan guru_id
        $userWalas = User::where('level', 'wali_kelas')->first();
        if ($userWalas) {
            $guru = Guru::skip(2)->first();
            if ($guru) {
                $userWalas->update(['guru_id' => $guru->id]);
            }
        }

        // Create orangtua data for ortu user
        $userOrtu = User::where('level', 'ortu')->first();
        if ($userOrtu) {
            $siswa = Siswa::first();
            if ($siswa) {
                $orangtua = Orangtua::create([
                    'user_id' => $userOrtu->id,
                    'siswa_id' => $siswa->id,
                    'hubungan' => 'ayah',
                    'nama_orangtua' => 'Bapak Test',
                    'pekerjaan' => 'Wiraswasta',
                    'pendidikan' => 'SMA',
                    'no_telp' => '081234567890',
                    'alamat' => 'Jl. Test No. 123'
                ]);
                
                $userOrtu->update(['ortu_id' => $orangtua->orangtua_id]);
            }
        }
    }
}