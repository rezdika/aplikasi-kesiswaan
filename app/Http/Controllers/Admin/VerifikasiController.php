<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VerifikasiData;
use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BackupData;
use App\Models\PelaksanaanSanksi;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $verifikasis = VerifikasiData::with([
            'guru.guru', 
            'siswa', 
            'pelanggaran.jenisPelanggaran', 
            'pelanggaran.sanksi.jenisSanksi', 
            'prestasi.jenisPrestasi'
        ])->latest()->get();
        return view('admin.verifikasi.index', compact('verifikasis'));
    }

    public function update(Request $request, VerifikasiData $verifikasi)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,ditolak,direvisi',
        ]);

        // Backup data sebelum verifikasi
        BackupData::create([
            'verifikasi_id' => $verifikasi->id,
            'data_lama' => json_encode($verifikasi->toArray()),
            'tanggal_backup' => now(),
        ]);

        $verifikasi->update(['status' => $request->status]);

        if ($request->status == 'diverifikasi') {
            if ($verifikasi->pelanggaran_id) {
                $pelanggaran = Pelanggaran::find($verifikasi->pelanggaran_id);
                $pelanggaran->update(['terverifikasi' => true]);

                $jenisSanksiId = $this->tentukan_sanksi_id($pelanggaran->poin);
                
                $sanksi = Sanksi::create([
                    'pelanggaran_id' => $pelanggaran->id,
                    'jenis_sanksi_id' => $jenisSanksiId,
                    'tanggal_mulai' => now()->format('Y-m-d'),
                    'status' => 'pending',
                    'catatan' => 'Sanksi otomatis dari verifikasi pelanggaran',
                ]);

                // Otomatis buat pelaksanaan sanksi untuk siswa
                PelaksanaanSanksi::create([
                    'sanksi_id' => $sanksi->id,
                    'tanggal_mulai' => now()->format('Y-m-d'),
                    'status' => 'proses',
                    'keterangan' => 'Menunggu pelaksanaan sanksi oleh siswa',
                ]);
            }

            if ($verifikasi->prestasi_id) {
                $prestasi = Prestasi::find($verifikasi->prestasi_id);
                $prestasi->update(['terverifikasi' => true]);
            }
        }

        return redirect()->route('admin.verifikasi.index')->with('success', 'Verifikasi berhasil diproses');
    }
    
    private function tentukan_sanksi_id($poin)
    {
        // Ambil jenis sanksi pertama sebagai default, atau buat logika sesuai poin
        $jenisSanksi = \App\Models\JenisSanksi::first();
        return $jenisSanksi ? $jenisSanksi->id : 1;
    }
}
