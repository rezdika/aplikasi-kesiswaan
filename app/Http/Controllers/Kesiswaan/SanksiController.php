<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\JenisSanksi;
use App\Models\PelaksanaanSanksi;
use App\Helpers\SuratSanksiHelper;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = Sanksi::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'jenisSanksi', 'pelaksanaanSanksi'])
            ->whereHas('pelanggaran')
            ->whereHas('pelanggaran.verifikasi', function($query) {
                $query->where('status', 'diverifikasi');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('kesiswaan.sanksi.index', compact('sanksi'));
    }

    public function create()
    {
        // Redirect karena sanksi sudah otomatis dibuat saat verifikasi
        return redirect()->route('kesiswaan.sanksi.index')
            ->with('info', 'Sanksi otomatis dibuat saat verifikasi pelanggaran. Anda hanya perlu mengubah status sanksi.');
    }

    public function store(Request $request)
    {
        // Method tidak digunakan karena sanksi otomatis dibuat
        return redirect()->route('kesiswaan.sanksi.index');
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'pelaksanaanSanksi']);
        return view('kesiswaan.sanksi.show', compact('sanksi'));
    }

    public function edit(Sanksi $sanksi)
    {
        $jenisSanksi = JenisSanksi::all();
        $sanksi->load(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'jenisSanksi']);

        return view('kesiswaan.sanksi.edit', compact('sanksi', 'jenisSanksi'));
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $request->validate([
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:direncanakan,berjalan,selesai,ditunda,dibatalkan',
        ]);

        $oldStatus = $sanksi->status;
        
        $sanksi->update([
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        // Jika status berubah dari bukan berjalan ke berjalan, buat pelaksanaan sanksi
        if ($oldStatus !== 'berjalan' && $request->status === 'berjalan') {
            if (!$sanksi->pelaksanaanSanksi) {
                PelaksanaanSanksi::create([
                    'sanksi_id' => $sanksi->id,
                    'tanggal_mulai' => now()->format('Y-m-d'),
                    'status' => 'terjadwal',
                    'catatan' => 'Sanksi diubah status menjadi berjalan',
                ]);
            }
            
            // Generate surat sanksi otomatis
            SuratSanksiHelper::generateSuratSanksi($sanksi);
        }

        return redirect()->route('kesiswaan.sanksi.index')->with('success', 'Sanksi berhasil diperbarui');
    }

    public function destroy(Sanksi $sanksi)
    {
        // Hapus pelaksanaan sanksi terlebih dahulu
        if ($sanksi->pelaksanaanSanksi) {
            $sanksi->pelaksanaanSanksi->delete();
        }
        
        $sanksi->delete();

        return redirect()->route('kesiswaan.sanksi.index')->with('success', 'Sanksi berhasil dihapus');
    }


    
    private function tentukan_sanksi($poin)
    {
        if ($poin >= 91) return 'Dikembalikan pada orang tua';
        if ($poin >= 41) return 'Diserahkan kepada orang tua dan dibina 1 bulan';
        if ($poin >= 36) return 'Diserahkan kepada orang tua dan dibina 2 minggu';
        if ($poin >= 31) return 'Diskorsing 7 hari';
        if ($poin >= 26) return 'Diskorsing 3 hari';
        if ($poin >= 21) return 'Perjanjian Orangtua di atas Materai';
        if ($poin >= 16) return 'Pemanggilan Orangtua dengan Perjanjian di atas Materai';
        if ($poin >= 11) return 'Teguran Tertulis dan Perjanjian';
        if ($poin >= 6) return 'Peringatan Lisan';
        return 'Dicatat dan Konseling';
    }
}