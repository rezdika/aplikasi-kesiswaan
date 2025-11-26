<?php

namespace App\Http\Controllers\Walas;

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
        // Cari guru_id dari user yang login
        $guruId = auth()->user()->guru_id;
        
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.kelas', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.kelas', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->where('terverifikasi', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('walas.export.index', compact('pelanggarans', 'prestasis', 'kepsek'));
    }

    public function exportPelanggaran(Request $request)
    {
        $guruId = auth()->user()->guru_id;
        
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.kelas', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
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
        return view('walas.export.pelanggaran', compact('pelanggarans', 'kepsek'));
    }

    public function exportPrestasi(Request $request)
    {
        $guruId = auth()->user()->guru_id;
        
        $query = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru', 'tahunAjaran'])
            ->whereHas('siswa.kelas', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
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
        return view('walas.export.prestasi', compact('prestasis', 'kepsek'));
    }

    public function suratSanksi($pelanggaranId)
    {
        $guruId = auth()->user()->guru_id;
        
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->whereHas('siswa.kelas', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->findOrFail($pelanggaranId);
            
        $kepsek = User::where('level', 'kepsek')->with('guru')->first();
        return view('walas.export.surat-sanksi', compact('pelanggaran', 'kepsek'));
    }

}