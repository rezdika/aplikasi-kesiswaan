<?php

namespace App\Http\Controllers\Walas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kelasId = auth()->user()->guru->kelas->id;
        
        // Stats Cards - Data kelas yang diampu
        $totalSiswa = Siswa::where('kelas_id', $kelasId)->count();
        $pelanggaranBulanIni = Pelanggaran::whereHas('siswa', function($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })->whereMonth('created_at', date('m'))->count();
        $totalPelanggaran = Pelanggaran::whereHas('siswa', function($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })->count();
        $pelanggaranTerverifikasi = Pelanggaran::whereHas('siswa', function($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })->where('terverifikasi', true)->count();
        
        // Pie Chart Data - Pelanggaran vs Prestasi
        $totalPrestasi = Prestasi::whereHas('siswa', function($query) use ($kelasId) {
            $query->where('kelas_id', $kelasId);
        })->count();
        
        // Top 5 Siswa Pelanggaran di kelas ini
        $topPelanggaran = Pelanggaran::select('siswa_id', DB::raw('count(*) as total'))
            ->whereHas('siswa', function($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->with('siswa')
            ->groupBy('siswa_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Pelanggaran Terbaru di kelas ini
        $pelanggaranTerbaru = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guru.guru', 'verifikasi'])
            ->whereHas('siswa', function($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->latest()
            ->limit(5)
            ->get();
        

        
        return view('walas.page.dashboard', compact(
            'totalSiswa',
            'pelanggaranBulanIni',
            'totalPelanggaran',
            'pelanggaranTerverifikasi',
            'totalPrestasi',
            'topPelanggaran',
            'pelanggaranTerbaru'
        ));
    }
}