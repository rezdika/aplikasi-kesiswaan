<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MonitoringPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\PelaksanaanSanksi;

class MonitoringController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guru.guru', 'verifikasi'])->latest()->get();
            
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru'])->where('terverifikasi', true)->latest()->get();

        $bk = BimbinganKonseling::with(['siswa.kelas', 'pelanggaran', 'bk.guru'])->where('status', 'selesai')->get();

        $pelaksanaanSanksis = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa.kelas'])
            ->whereHas('sanksi.pelanggaran.siswa')
            ->latest()
            ->get();
            
        return view('admin.monitoring.index', compact('pelanggarans', 'prestasis', 'bk', 'pelaksanaanSanksis'));
    }
}
