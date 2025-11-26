<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sanksi;
use App\Models\JenisSanksi;
use App\Models\Pelanggaran;
use App\Models\PelaksanaanSanksi;
use App\Models\MonitoringPelanggaran;
use App\Helpers\SuratSanksiHelper;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index()
    {
        $sanksi = Sanksi::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'jenisSanksi', 'pelaksanaan'])->whereHas('pelanggaran')->latest()->paginate(10);
        return view('admin.sanksi.index', compact('sanksi'));
    }

    public function show(Sanksi $sanksi)
    {
        $sanksi->load(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'jenisSanksi', 'pelaksanaan']);
        return view('admin.sanksi.show', compact('sanksi'));
    }

    public function create()
    {
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->whereHas('verifikasi', function($query) {
                $query->where('status', 'diverifikasi');
            })
            ->whereDoesntHave('sanksi')
            ->get();
        $jenisSanksi = JenisSanksi::all();
        return view('admin.sanksi.create', compact('pelanggaran', 'jenisSanksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi_id' => 'required|exists:jenis_sanksi,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->only(['pelanggaran_id', 'jenis_sanksi_id', 'tanggal_mulai', 'tanggal_selesai', 'catatan']);
        $data['status'] = 'pending';

        $sanksi = Sanksi::create($data);
        
        // Buat notifikasi untuk siswa terkait
        // TODO: Implementasi notifikasi
        
        return redirect()->route('admin.sanksi.index')->with('success', 'Sanksi berhasil ditambahkan');
    }

    public function edit(Sanksi $sanksi)
    {
        $pelanggaran = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->whereHas('verifikasi', function($query) {
                $query->where('status', 'diverifikasi');
            })
            ->get();
        $jenisSanksi = JenisSanksi::all();
        return view('admin.sanksi.edit', compact('sanksi', 'pelanggaran', 'jenisSanksi'));
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi_id' => 'required|exists:jenis_sanksi,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:pending,berlangsung,selesai',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->only(['pelanggaran_id', 'jenis_sanksi_id', 'tanggal_mulai', 'tanggal_selesai', 'status', 'catatan']);
        $oldStatus = $sanksi->status;

        $sanksi->update($data);
        
        // Generate surat sanksi otomatis jika status berubah ke berjalan
        if ($oldStatus !== 'berjalan' && $request->status === 'berjalan') {
            SuratSanksiHelper::generateSuratSanksi($sanksi);
        }
        
        return redirect()->route('admin.sanksi.index')->with('success', 'Sanksi berhasil diupdate');
    }

    public function destroy(Sanksi $sanksi)
    {
        // Cek apakah sanksi masih digunakan
        if ($sanksi->pelaksanaan()->count() > 0) {
            return redirect()->route('admin.sanksi.index')->with('error', 'Sanksi tidak dapat dihapus karena masih memiliki data pelaksanaan');
        }
        
        $sanksi->delete();
        return redirect()->route('admin.sanksi.index')->with('success', 'Sanksi berhasil dihapus');
    }

    public function viewOnly()
    {
        $sanksi = Sanksi::with(['pelanggaran.siswa', 'pelanggaran.jenisPelanggaran', 'jenisSanksi', 'pelaksanaan'])
            ->whereHas('pelanggaran')
            ->whereHas('pelanggaran.verifikasi', function($query) {
                $query->where('status', 'diverifikasi');
            })
            ->latest()->paginate(10);
        return view('admin.sanksi.sanksi', compact('sanksi'));
    }
}