<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\VerifikasiData;
use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\PelaksanaanSanksi;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $verifikasis = VerifikasiData::with([
            'guru.guru', 
            'siswa', 
            'pelanggaran.jenisPelanggaran', 
            'pelanggaran.siswa', 
            'pelanggaran.sanksi', 
            'prestasi.jenisPrestasi',
            'prestasi.siswa'
        ])->latest()->get();
        return view('kesiswaan.verifikasi.index', compact('verifikasis'));
    }

    public function update(Request $request, VerifikasiData $verifikasi)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,ditolak,direvisi',
        ]);

        $verifikasi->update(['status' => $request->status]);

        if ($request->status == 'diverifikasi') {
            if ($verifikasi->pelanggaran_id) {
                $pelanggaran = Pelanggaran::find($verifikasi->pelanggaran_id);
                $pelanggaran->update(['terverifikasi' => true]);
                
                // Otomatis buat sanksi berdasarkan total poin siswa
                $this->buatSanksiOtomatis($pelanggaran);
                
                NotificationHelper::dataVerifikasi($verifikasi, 'pelanggaran', true);
            }

            if ($verifikasi->prestasi_id) {
                $prestasi = Prestasi::find($verifikasi->prestasi_id);
                $prestasi->update(['terverifikasi' => true]);
                NotificationHelper::dataVerifikasi($verifikasi, 'prestasi', true);
            }
        } else {
            // Jika ditolak atau direvisi
            $type = $verifikasi->pelanggaran_id ? 'pelanggaran' : 'prestasi';
            NotificationHelper::dataVerifikasi($verifikasi, $type, false);
        }

        return redirect()->route('kesiswaan.verifikasi.index')->with('success', 'Verifikasi berhasil diproses');
    }
    
    private function buatSanksiOtomatis($pelanggaran)
    {
        $siswaId = $pelanggaran->siswa_id;
        
        // Hitung total poin pelanggaran siswa yang terverifikasi
        $totalPoin = Pelanggaran::where('siswa_id', $siswaId)
            ->where('terverifikasi', true)
            ->sum('poin');
            
        // Tentukan jenis sanksi berdasarkan total poin
        $jenisSanksiId = $this->tentukanSanksiByPoin($totalPoin);
        
        if (!$jenisSanksiId) {
            return;
        }
        
        // Cek apakah siswa memiliki sanksi aktif (direncanakan)
        $sanksiAktif = Sanksi::whereHas('pelanggaran', function($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->where('status', 'direncanakan')
          ->whereDoesntHave('pelaksanaanSanksi')
          ->first();
          
        if ($sanksiAktif) {
            // Update sanksi yang sudah ada jika jenis sanksi berubah
            if ($sanksiAktif->jenis_sanksi_id != $jenisSanksiId) {
                $sanksiAktif->update([
                    'jenis_sanksi_id' => $jenisSanksiId,
                    'catatan' => $sanksiAktif->catatan . ' | Diperbarui karena pelanggaran baru (Total poin: ' . $totalPoin . ')'
                ]);
                
                // Kirim notifikasi sanksi diperbarui
                NotificationHelper::sanksiDiperbarui($sanksiAktif);
            }
        } else {
            // Buat sanksi baru jika belum ada sanksi aktif
            $sanksi = Sanksi::create([
                'pelanggaran_id' => $pelanggaran->id,
                'jenis_sanksi_id' => $jenisSanksiId,
                'tanggal_mulai' => now()->format('Y-m-d'),
                'tanggal_selesai' => now()->addDays(30)->format('Y-m-d'),
                'status' => 'direncanakan',
                'catatan' => 'Sanksi otomatis berdasarkan total poin: ' . $totalPoin
            ]);
            
            // Kirim notifikasi sanksi baru
            NotificationHelper::saksiBaru($sanksi);
        }
    }
    
    private function tentukanSanksiByPoin($poin)
    {
        if ($poin >= 91) return 9; 
        if ($poin >= 36) return 8; 
        if ($poin >= 31) return 7; 
        if ($poin >= 26) return 6; 
        if ($poin >= 21) return 5; 
        if ($poin >= 16) return 4; 
        if ($poin >= 11) return 3; 
        if ($poin >= 6) return 2; 
        return 1; 
    }
}
