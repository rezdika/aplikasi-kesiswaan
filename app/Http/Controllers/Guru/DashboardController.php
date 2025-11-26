<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Stats Cards - Data yang dicatat oleh guru ini
        $totalSiswa = Siswa::count();
        $pelanggaranSaya = Pelanggaran::where('guru_id', $userId)->count();
        $pelanggaranBulanIni = Pelanggaran::where('guru_id', $userId)
            ->whereMonth('created_at', date('m'))
            ->count();
        
        // Chart Data - 6 bulan terakhir
        $chartData = $this->getChartData($userId);
        
        // Top 5 Jenis Pelanggaran yang dicatat guru ini
        $topPelanggaran = Pelanggaran::select('jenis_pelanggaran_id', DB::raw('count(*) as total'))
            ->where('guru_id', $userId)
            ->with('jenisPelanggaran')
            ->groupBy('jenis_pelanggaran_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Pelanggaran Terbaru yang dicatat guru ini
        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('guru_id', $userId)
            ->latest()
            ->limit(5)
            ->get();
        
        return view('guru.page.dashboard', compact(
            'totalSiswa',
            'pelanggaranSaya',
            'pelanggaranBulanIni',
            'chartData',
            'topPelanggaran',
            'pelanggaranTerbaru'
        ));
    }
    
    private function getChartData($userId)
    {
        $months = [];
        $pelanggaran = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $pelanggaranCount = Pelanggaran::where('guru_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $pelanggaran[] = $pelanggaranCount;
        }
        
        return [
            'labels' => $months,
            'pelanggaran' => $pelanggaran
        ];
    }
}