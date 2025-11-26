<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling as BkModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards - BK melihat semua data
        $totalSiswa = Siswa::count();
        $totalBimbingan = BkModel::count();
        $pelanggaranBulanIni = Pelanggaran::whereMonth('created_at', date('m'))->count();
        $bimbinganBulanIni = BkModel::whereMonth('created_at', date('m'))->count();
        
        // Chart Data - 6 Bulan Terakhir
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chartData['labels'][] = date('M Y', strtotime("-$i months"));
            $chartData['pelanggaran'][] = Pelanggaran::where('created_at', 'like', "$month%")->count();
            $chartData['bimbingan'][] = BkModel::where('created_at', 'like', "$month%")->count();
        }
        
        // Top 5 Siswa dengan Pelanggaran Terbanyak (untuk bimbingan)
        $topPelanggaran = Pelanggaran::select('siswa_id', DB::raw('count(*) as total'))
            ->with('siswa.kelas')
            ->groupBy('siswa_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Pelanggaran Terbaru (untuk monitoring)
        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Bimbingan Terbaru
        $bimbinganTerbaru = BkModel::with(['siswa.kelas', 'pelanggaran.jenisPelanggaran'])
            ->latest()
            ->limit(5)
            ->get();
        
        return view('bk.page.dashboard', compact(
            'totalSiswa',
            'totalBimbingan',
            'pelanggaranBulanIni',
            'bimbinganBulanIni',
            'chartData',
            'topPelanggaran',
            'pelanggaranTerbaru',
            'bimbinganTerbaru'
        ));
    }
}