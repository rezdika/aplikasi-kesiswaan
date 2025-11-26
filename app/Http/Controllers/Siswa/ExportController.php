<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        // Cari siswa_id dari user yang login
        $siswaId = auth()->user()->siswa_id;
        
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->where('siswa_id', $siswaId)
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->where('siswa_id', $siswaId)
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('siswa.export.index', compact('pelanggarans', 'prestasis', 'kepsek'));
    }

    public function exportPelanggaran(Request $request)
    {
        $siswaId = auth()->user()->siswa_id;
        
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->where('siswa_id', $siswaId)
            ->where('terverifikasi', true);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        $pelanggarans = $query->orderBy('created_at', 'desc')->get();
        
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('siswa.export.pelanggaran', compact('pelanggarans', 'kepsek'));
    }

    public function exportPrestasi(Request $request)
    {
        $siswaId = auth()->user()->siswa_id;
        
        $query = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->where('siswa_id', $siswaId)
            ->where('terverifikasi', true);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        $prestasis = $query->orderBy('created_at', 'desc')->get();
        
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('siswa.export.prestasi', compact('prestasis', 'kepsek'));
    }

    public function suratSanksi($pelanggaranId)
    {
        $siswaId = auth()->user()->siswa_id;
        
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->where('siswa_id', $siswaId)
            ->findOrFail($pelanggaranId);
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('siswa.export.surat-sanksi', compact('pelanggaran', 'kepsek'));
    }

    public function konfirmasiSuratSanksi($pelanggaranId)
    {
        $siswaId = auth()->user()->siswa_id;
        
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->where('siswa_id', $siswaId)
            ->findOrFail($pelanggaranId);
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('siswa.export.konfirmasi-surat-sanksi', compact('pelanggaran', 'kepsek'));
    }

    public function simpanKonfirmasi(Request $request, $pelanggaranId)
    {
        $siswaId = auth()->user()->siswa_id;
        
        $pelanggaran = Pelanggaran::where('siswa_id', $siswaId)
            ->findOrFail($pelanggaranId);

        \App\Models\KonfirmasiSurat::create([
            'pelanggaran_id' => $pelanggaranId,
            'siswa_id' => $siswaId,
            'jenis_konfirmasi' => 'siswa',
            'tanggal_konfirmasi' => now(),
            'status' => 'dikonfirmasi',
            'catatan' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Konfirmasi berhasil disimpan');
    }
}