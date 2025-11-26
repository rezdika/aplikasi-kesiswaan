<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\PelaksanaanSanksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards
        $pelanggaranBulanIni = Pelanggaran::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        $prestasiBulanIni = Prestasi::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();
        $menungguVerifikasi = Pelanggaran::whereNull('terverifikasi')->count() + 
                              Prestasi::whereNull('terverifikasi')->count();
        $sanksiSelesai = PelaksanaanSanksi::where('status', 'selesai')
            ->whereMonth('updated_at', date('m'))
            ->count();
        
        // Chart Data - 6 Bulan Terakhir
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chartData['labels'][] = date('M Y', strtotime("-$i months"));
            $chartData['pelanggaran'][] = Pelanggaran::where('created_at', 'like', "$month%")->count();
            $chartData['prestasi'][] = Prestasi::where('created_at', 'like', "$month%")->count();
        }
        
        // Donut Chart - Status Verifikasi
        $totalData = Pelanggaran::count() + Prestasi::count();
        $terverifikasi = Pelanggaran::where('terverifikasi', true)->count() + 
                        Prestasi::where('terverifikasi', true)->count();
        $belumVerifikasi = $totalData - $terverifikasi;
        $donutData = [
            'terverifikasi' => $terverifikasi,
            'belum' => $belumVerifikasi
        ];
        
        // Data Menunggu Verifikasi
        $dataVerifikasi = collect();
        $pelanggaranPending = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->whereNull('terverifikasi')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'jenis' => 'Pelanggaran',
                    'siswa' => $p->siswa->nama_siswa ?? '-',
                    'detail' => $p->jenisPelanggaran->nama ?? '-',
                    'tanggal' => $p->created_at->format('d/m/Y')
                ];
            });
        $prestasiPending = Prestasi::with(['siswa', 'jenisPrestasi'])
            ->whereNull('terverifikasi')
            ->latest()
            ->limit(2)
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->id,
                    'jenis' => 'Prestasi',
                    'siswa' => $p->siswa->nama_siswa ?? '-',
                    'detail' => $p->jenisPrestasi->nama ?? '-',
                    'tanggal' => $p->created_at->format('d/m/Y')
                ];
            });
        $dataVerifikasi = $pelanggaranPending->concat($prestasiPending)->take(5);
        
        // Pelaksanaan Sanksi Terbaru
        $sanksiTerbaru = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa'])
            ->where('status', 'selesai')
            ->latest('updated_at')
            ->limit(5)
            ->get();
        
        return view('kesiswaan.page.dashboard', compact(
            'pelanggaranBulanIni',
            'prestasiBulanIni',
            'menungguVerifikasi',
            'sanksiSelesai',
            'chartData',
            'donutData',
            'dataVerifikasi',
            'sanksiTerbaru'
        ));
    }
}