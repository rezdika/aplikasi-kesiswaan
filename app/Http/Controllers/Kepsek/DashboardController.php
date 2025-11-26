<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\User;
use App\Models\PelaksanaanSanksi;
use App\Models\MonitoringPelanggaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards
        $totalSiswa = Siswa::count();
        $totalPelanggaran = Pelanggaran::count();
        $totalPrestasi = Prestasi::count();
        $pelanggaranBulanIni = Pelanggaran::whereMonth('created_at', date('m'))->count();
        $prestasiBulanIni = Prestasi::whereMonth('created_at', date('m'))->count();
        // Monitoring counts
        $totalPelanggaranTerverifikasi = Pelanggaran::whereHas('verifikasi', function($query) {
            $query->where('status', 'diverifikasi');
        })->count();
        $monitoringSudahCatatan = MonitoringPelanggaran::whereNotNull('catatan')->count();
        $monitoringBelumCatatan = $totalPelanggaranTerverifikasi - $monitoringSudahCatatan;
        
        // Chart Data - 6 Bulan Terakhir
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chartData['labels'][] = date('M Y', strtotime("-$i months"));
            $chartData['pelanggaran'][] = Pelanggaran::where('created_at', 'like', "$month%")->count();
            $chartData['prestasi'][] = Prestasi::where('created_at', 'like', "$month%")->count();
        }
        
        // Top 5 Siswa Pelanggaran
        $topPelanggaran = Pelanggaran::select('siswa_id', \DB::raw('count(*) as total'))
            ->with('siswa')
            ->groupBy('siswa_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Top 5 Siswa Prestasi
        $topPrestasi = Prestasi::select('siswa_id', \DB::raw('count(*) as total'))
            ->with('siswa')
            ->groupBy('siswa_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        return view('kepsek.page.dashboard', compact(
            'totalSiswa',
            'totalPelanggaran',
            'totalPrestasi',
            'pelanggaranBulanIni',
            'prestasiBulanIni',
            'chartData',
            'topPelanggaran',
            'topPrestasi',
            'monitoringBelumCatatan',
            'monitoringSudahCatatan'
        ));
    }
}