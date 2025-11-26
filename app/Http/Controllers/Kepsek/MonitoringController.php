<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\MonitoringPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\PelaksanaanSanksi;
use App\Models\Notification;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat', 'verifikasi', 'monitoring'])
            ->latest()
            ->get();
            
        $prestasis = Prestasi::with(['siswa.kelas', 'jenisPrestasi', 'guru.guru'])
            ->latest()
            ->get();

        $bk = BimbinganKonseling::with(['siswa.kelas', 'pelanggaran', 'bk.guru'])->where('status', 'selesai')->get();

        $pelaksanaanSanksis = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa.kelas'])
            ->whereHas('sanksi.pelanggaran.siswa')
            ->latest()
            ->get();
            
        return view('kepsek.monitoring.index', compact('pelanggarans', 'prestasis', 'bk', 'pelaksanaanSanksis'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'catatan' => 'required|string|max:500',
            'status' => 'required|in:dipantau,ditindaklanjuti,selesai'
        ]);

        // Update atau buat monitoring baru
        MonitoringPelanggaran::updateOrCreate(
            ['pelanggaran_id' => $pelanggaran->id],
            [
                'kepsek_id' => auth()->id(),
                'catatan' => $request->catatan,
                'status' => $request->status
            ]
        );

        // Kirim notifikasi ke guru pencatat
        if ($pelanggaran->guru_id) {
            Notification::create([
                'user_id' => $pelanggaran->guru_id,
                'title' => 'Catatan Kepsek - Pelanggaran Siswa',
                'message' => 'Kepala sekolah memberikan catatan: ' . $request->catatan,
                'url' => route('guru.pelanggaran.index'),
                'is_read' => false
            ]);
        }

        // Kirim notifikasi ke kesiswaan
        $kesiswaan = \App\Models\User::where('level', 'kesiswaan')->first();
        if ($kesiswaan) {
            Notification::create([
                'user_id' => $kesiswaan->id,
                'title' => 'Catatan Kepsek - Monitoring Pelanggaran',
                'message' => 'Kepala sekolah memberikan catatan monitoring: ' . $request->catatan,
                'url' => route('kesiswaan.monitoring.index'),
                'is_read' => false
            ]);
        }

        return redirect()->route('kepsek.monitoring.index')
            ->with('success', 'Catatan monitoring berhasil ditambahkan dan notifikasi telah dikirim.');
    }
}
