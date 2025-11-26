<?php

namespace App\Http\Controllers\Kepsek;

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
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('kepsek.export.index', compact('pelanggarans', 'prestasis', 'kepsek'));
    }

    public function exportPelanggaran(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->where('terverifikasi', true);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        $pelanggarans = $query->orderBy('created_at', 'desc')->get();
        
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('kepsek.export.pelanggaran', compact('pelanggarans', 'kepsek'));
    }

    public function suratSanksi($pelanggaranId)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->findOrFail($pelanggaranId);
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('kepsek.export.surat-sanksi', compact('pelanggaran', 'kepsek'));
    }

    public function exportPrestasi(Request $request)
    {
        $query = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->where('terverifikasi', true);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        $prestasis = $query->orderBy('created_at', 'desc')->get();
        
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('kepsek.export.prestasi', compact('prestasis', 'kepsek'));
    }

}