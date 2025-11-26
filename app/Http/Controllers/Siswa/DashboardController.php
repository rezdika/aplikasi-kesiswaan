<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa as SiswaModel;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\PelaksanaanSanksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $siswaId = $user->siswa->id;
        
        // Stats Cards - Data siswa ini
        $totalPelanggaran = Pelanggaran::where('siswa_id', $siswaId)->count();
        $totalPrestasi = Prestasi::where('siswa_id', $siswaId)->count();
        $pelanggaranBulanIni = Pelanggaran::where('siswa_id', $siswaId)
            ->whereMonth('created_at', date('m'))
            ->count();
        $sanksiAktif = PelaksanaanSanksi::whereHas('sanksi.pelanggaran', function($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->where('status', 'proses')->count();
        
        // Pie Chart Data
        $totalPoinPelanggaran = Pelanggaran::where('siswa_id', $siswaId)->sum('poin');
        $totalPoinPrestasi = Prestasi::where('siswa_id', $siswaId)->sum('poin');
        
        // Pelanggaran Terbaru
        $pelanggaranTerbaru = Pelanggaran::with(['jenisPelanggaran', 'guru.guru'])
            ->where('siswa_id', $siswaId)
            ->latest()
            ->limit(5)
            ->get();
        
        // Prestasi Terbaru
        $prestasiTerbaru = Prestasi::with(['jenisPrestasi', 'guru.guru'])
            ->where('siswa_id', $siswaId)
            ->latest()
            ->limit(5)
            ->get();
        
        // Sanksi Aktif
        $sanksiAktifList = PelaksanaanSanksi::with(['sanksi.pelanggaran.jenisPelanggaran'])
            ->whereHas('sanksi.pelanggaran', function($query) use ($siswaId) {
                $query->where('siswa_id', $siswaId);
            })
            ->where('status', 'proses')
            ->latest()
            ->limit(5)
            ->get();
        
        return view('siswa.page.dashboard', compact(
            'totalPelanggaran',
            'totalPrestasi',
            'pelanggaranBulanIni',
            'sanksiAktif',
            'totalPoinPelanggaran',
            'totalPoinPrestasi',
            'pelanggaranTerbaru',
            'prestasiTerbaru',
            'sanksiAktifList'
        ));
    }
}