<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisSanksi;

class JenisSanksiSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSanksi = [
            [
                'nama_sanksi' => 'Dicatat dan Konseling',
                'kategori' => 'Ringan',
                'deskripsi' => 'Apabila skor pelanggaran mencapai 1 s/d 5 maka dikategorikan ringan berupa dicatat dan konseling'
            ],
            [
                'nama_sanksi' => '6-10 Peringatan Lisan',
                'kategori' => 'Ringan',
                'deskripsi' => '6-10 peringatan lisan'
            ],
            [
                'nama_sanksi' => '11-15 Peringatan Tertulis dengan Perjanjian',
                'kategori' => 'Sedang',
                'deskripsi' => '11-15 peringatan tertulis dengan perjanjian'
            ],
            [
                'nama_sanksi' => '16-20 Panggilan Orang Tua dengan Perjanjian Siswa Diatas Materai',
                'kategori' => 'Sedang',
                'deskripsi' => '16-20 panggilan orang tua dengan perjanjian siswa diatas materai'
            ],
            [
                'nama_sanksi' => '21-25 Perjanjian Orang Tua dengan Perjanjian Diatas Materai',
                'kategori' => 'Sedang',
                'deskripsi' => '21-25 perjanjian orang tua dengan perjanjian diatas materai'
            ],
            [
                'nama_sanksi' => '26-30 Diskors Selama 3 Hari',
                'kategori' => 'Berat',
                'deskripsi' => '26-30 diskors selama 3 hari'
            ],
            [
                'nama_sanksi' => '31-35 Diskors Selama 7 Hari',
                'kategori' => 'Berat',
                'deskripsi' => '31-35 diskors selama 7 hari'
            ],
            [
                'nama_sanksi' => '36-40 Diserahkan kepada Orang Tua untuk Dibina dalam Jangka Waktu Dua (2) Minggu',
                'kategori' => 'Berat',
                'deskripsi' => '36-40 diserahkan kepada orang tua untuk dibina dalam jangka waktu dua (2) minggu'
            ],
            [
                'nama_sanksi' => 'Dikeluarkan dari Sekolah',
                'kategori' => 'Sangat Berat',
                'deskripsi' => 'Perjanjian diatas materai. Skors diserahkan kepada orang tua dan apabila sudah mencapai 100 dikeluarkan dari sekolah'
            ]
        ];

        foreach ($jenisSanksi as $data) {
            JenisSanksi::create($data);
        }
    }
}