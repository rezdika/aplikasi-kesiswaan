<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Orangtua;
use App\Models\JenisPelanggaran;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards - ADMIN ONLY
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalOrtu = Orangtua::count();
        
        // Chart Data - 6 Bulan Terakhir
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chartData['labels'][] = date('M Y', strtotime("-$i months"));
            $chartData['pelanggaran'][] = Pelanggaran::where('created_at', 'like', "$month%")->count();
            $chartData['prestasi'][] = Prestasi::where('created_at', 'like', "$month%")->count();
        }
        
        // Top 5 Jenis Pelanggaran
        $topPelanggaran = Pelanggaran::select('jenis_pelanggaran_id', DB::raw('count(*) as total'))
            ->with('jenisPelanggaran')
            ->groupBy('jenis_pelanggaran_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Pelanggaran Terbaru (Semua - Admin bisa lihat semua)
        $pelanggaranTerbaru = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Prestasi Terbaru (Semua - Admin bisa lihat semua)
        $prestasiTerbaru = Prestasi::with(['siswa', 'jenisPrestasi'])
            ->latest()
            ->limit(5)
            ->get();
        
        return view('admin.page.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalOrtu',
            'chartData',
            'topPelanggaran',
            'pelanggaranTerbaru',
            'prestasiTerbaru'
        ));
    }
}
