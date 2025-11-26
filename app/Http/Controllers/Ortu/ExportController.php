<?php

namespace App\Http\Controllers\Ortu;

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
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('ortu.export.index', compact('pelanggarans', 'prestasis', 'kepsek'));
    }

    public function exportPelanggaran(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('terverifikasi', true);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        $pelanggarans = $query->orderBy('created_at', 'desc')->get();
        
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('ortu.export.pelanggaran', compact('pelanggarans', 'kepsek'));
    }

    public function exportPrestasi(Request $request)
    {
        $query = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('terverifikasi', true);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        $prestasis = $query->orderBy('created_at', 'desc')->get();
        
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('ortu.export.prestasi', compact('prestasis', 'kepsek'));
    }

    public function suratSanksi($pelanggaranId)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($pelanggaranId);
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('ortu.export.surat-sanksi', compact('pelanggaran', 'kepsek'));
    }

    public function konfirmasiSuratSanksi($pelanggaranId)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($pelanggaranId);
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('ortu.export.konfirmasi-surat-sanksi', compact('pelanggaran', 'kepsek'));
    }

    public function simpanKonfirmasi(Request $request, $pelanggaranId)
    {
        $pelanggaran = Pelanggaran::with('siswa')
            ->whereHas('siswa.orangtua', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($pelanggaranId);

        \App\Models\KonfirmasiSurat::create([
            'pelanggaran_id' => $pelanggaranId,
            'siswa_id' => $pelanggaran->siswa->id,
            'orangtua_id' => auth()->id(),
            'jenis_konfirmasi' => 'orangtua',
            'tanggal_konfirmasi' => now(),
            'status' => 'dikonfirmasi',
            'catatan' => $request->catatan
        ]);

        return redirect()->back()->with('success', 'Konfirmasi berhasil disimpan');
    }
}