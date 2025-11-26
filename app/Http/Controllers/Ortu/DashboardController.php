<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\PelaksanaanSanksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ortu = $user->orangtuaUser;
        
        // Get siswa ID from orangtua relation
        if ($user->orangtuaUser && $user->orangtuaUser->siswa) {
            $siswaId = $user->orangtuaUser->siswa->id;
        } elseif ($user->orangtua?->siswa) {
            $siswaId = $user->orangtua->siswa->id;
        } else {
            // Fallback jika tidak ada relasi siswa
            return view('ortu.page.dashboard')->with('error', 'Data siswa tidak ditemukan');
        }
        
        // Stats Cards - Data anak
        $totalPelanggaran = Pelanggaran::where('siswa_id', $siswaId)->count();
        $totalPrestasi = Prestasi::where('siswa_id', $siswaId)->count();
        $pelanggaranBulanIni = Pelanggaran::where('siswa_id', $siswaId)
            ->whereMonth('created_at', date('m'))
            ->count();
        $sanksiAktif = PelaksanaanSanksi::whereHas('sanksi.pelanggaran', function($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->where('status', 'dikerjakan')->count();
        
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
            ->where('status', 'dikerjakan')
            ->latest()
            ->limit(5)
            ->get();
        
        return view('ortu.page.dashboard', compact(
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