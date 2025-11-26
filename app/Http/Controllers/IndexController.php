<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\BimbinganKonseling;
use App\Models\JenisPelanggaran;
use App\Models\Kelas;
use App\Models\Prestasi;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index() {
        $totalSiswa = Siswa::count();
        
        $totalPrestasi = Prestasi::count();
        $siswaWithPrestasi = Prestasi::distinct('siswa_id')->count('siswa_id');
        $persentaseSiswaBerprestasi = $totalSiswa > 0 
            ? round(($siswaWithPrestasi / $totalSiswa) * 100) 
            : 0;
        
        $siswaWithPelanggaran = Pelanggaran::distinct('siswa_id')->count('siswa_id');
        $siswaTanpaPelanggaran = $totalSiswa - $siswaWithPelanggaran;
        $persentaseSiswaBaik = $totalSiswa > 0 
            ? round(($siswaTanpaPelanggaran / $totalSiswa) * 100) 
            : 0;
        
        $jenisPelanggaran = JenisPelanggaran::all();
        $kelas = Kelas::all();
        $bimbingan = BimbinganKonseling::with('siswa')->latest()->take(10)->get();
        
        $pelanggaranPerSemester = DB::table('tahun_ajaran')
            ->select('tahun_ajaran.tahun_ajaran', 'tahun_ajaran.semester', DB::raw('COUNT(pelanggaran.id) as total_pelanggaran'))
            ->leftJoin('pelanggaran', 'tahun_ajaran.id', '=', 'pelanggaran.tahun_ajaran_id')
            ->groupBy('tahun_ajaran.id', 'tahun_ajaran.tahun_ajaran', 'tahun_ajaran.semester')
            ->orderBy('tahun_ajaran.tahun_ajaran', 'desc')
            ->orderBy('tahun_ajaran.semester', 'desc')
            ->limit(3)
            ->get();
        
        return view('index', compact('totalSiswa', 'persentaseSiswaBerprestasi', 'persentaseSiswaBaik', 'jenisPelanggaran', 'kelas', 'bimbingan', 'pelanggaranPerSemester'));
    }
}
