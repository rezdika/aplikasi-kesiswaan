<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\VerifikasiData;
use App\Models\MonitoringPelanggaran;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guru', 'verifikasi'])
            ->where('guru_id', auth()->id())
            ->latest()->get();
        return view('guru.pelanggaran.index', compact('pelanggarans'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $jenisPelanggarans = JenisPelanggaran::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        return view('guru.pelanggaran.create', compact('siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'keterangan' => 'nullable',
        ]);
    
        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan,
            'guru_id' => auth()->id()
        ]);
        
        // Cek apakah siswa memiliki sanksi aktif yang belum selesai
        $this->updateSanksiAktif($request->siswa_id);
        
        VerifikasiData::create([
            'pelanggaran_id' => $pelanggaran->id,
            'siswa_id' => $request->siswa_id,
            'guru_id' => auth()->id(),
            'status' => 'menunggu',
        ]);
        
        // Buat monitoring otomatis
        MonitoringPelanggaran::create([
            'pelanggaran_id' => $pelanggaran->id,
            'status' => 'baru',
            'catatan' => 'Pelanggaran baru dari guru: ' . auth()->user()->name,
        ]);
        
        NotificationHelper::pelanggaranBaru($pelanggaran);
        
        return redirect()->route('guru.pelanggaran.index')->with('success', 'Pelanggaran berhasil ditambahkan dan menunggu verifikasi');
    }
    
    private function updateSanksiAktif($siswaId)
    {
        // Cari sanksi yang masih direncanakan (belum berjalan) untuk siswa ini
        $sanksiAktif = \App\Models\Sanksi::whereHas('pelanggaran', function($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->where('status', 'direncanakan')
          ->whereDoesntHave('pelaksanaanSanksi')
          ->first();
          
        if ($sanksiAktif) {
            // Hitung total poin pelanggaran siswa yang terverifikasi
            $totalPoin = \App\Models\Pelanggaran::where('siswa_id', $siswaId)
                ->where('terverifikasi', true)
                ->sum('poin');
                
            // Tentukan sanksi baru berdasarkan total poin
            $sanksiBaruId = $this->tentukanSanksiByPoin($totalPoin);
            
            if ($sanksiBaruId && $sanksiBaruId != $sanksiAktif->jenis_sanksi_id) {
                // Update sanksi dengan jenis sanksi yang lebih berat
                $sanksiAktif->update([
                    'jenis_sanksi_id' => $sanksiBaruId,
                    'catatan' => $sanksiAktif->catatan . ' | Diperbarui karena pelanggaran baru (Total poin: ' . $totalPoin . ')'
                ]);
                
                // Kirim notifikasi ke wali kelas tentang perubahan sanksi
                \App\Helpers\NotificationHelper::sanksiDiperbarui($sanksiAktif);
            }
        }
    }
    
    private function tentukanSanksiByPoin($poin)
    {
        // Mapping poin ke jenis sanksi ID berdasarkan data di database
        if ($poin >= 91) return 9; // Dikeluarkan dari Sekolah
        if ($poin >= 36) return 8; // Diserahkan kepada Orang Tua untuk Dibina 2 Minggu
        if ($poin >= 31) return 7; // Diskors Selama 7 Hari
        if ($poin >= 26) return 6; // Diskors Selama 3 Hari
        if ($poin >= 21) return 5; // Perjanjian Orang Tua dengan Perjanjian Diatas Materai
        if ($poin >= 16) return 4; // Panggilan Orang Tua dengan Perjanjian Siswa Diatas Materai
        if ($poin >= 11) return 3; // Peringatan Tertulis dengan Perjanjian
        if ($poin >= 6) return 2; // Peringatan Lisan
        return 1; // Dicatat dan Konseling
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        // Pastikan guru hanya bisa edit pelanggaran yang dicatat sendiri
        if ($pelanggaran->guru_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pelanggaran ini');
        }
        
        $siswas = Siswa::all();
        $jenisPelanggarans = JenisPelanggaran::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        return view('guru.pelanggaran.edit', compact('pelanggaran', 'siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        // Pastikan guru hanya bisa update pelanggaran yang dicatat sendiri
        if ($pelanggaran->guru_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate pelanggaran ini');
        }
        
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'keterangan' => 'nullable',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $pelanggaran->update([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('guru.pelanggaran.index')->with('success', 'Pelanggaran berhasil diupdate');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        // Pastikan guru hanya bisa hapus pelanggaran yang dicatat sendiri
        if ($pelanggaran->guru_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pelanggaran ini');
        }
        
        if ($pelanggaran->terverifikasi === false) {
            $pelanggaran->delete();
            return redirect()->route('guru.pelanggaran.index')->with('success', 'Pelanggaran yang ditolak berhasil dihapus');
        }
        
        return redirect()->route('guru.pelanggaran.index')->with('error', 'Hanya pelanggaran yang ditolak yang dapat dihapus');
    }
}
