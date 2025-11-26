<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\VerifikasiData;
use App\Models\MonitoringPelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guruPencatat.guru', 'verifikasi'])->latest()->get();
        return view('kesiswaan.pelanggaran.index', compact('pelanggarans'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $jenisPelanggarans = JenisPelanggaran::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        return view('kesiswaan.pelanggaran.create', compact('siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'keterangan' => 'nullable',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan,
            'guru_id' => auth()->id()
        ]);
        
        VerifikasiData::create([
            'pelanggaran_id' => $pelanggaran->id,
            'siswa_id' => $request->siswa_id,
            'guru_id' => auth()->id(),
            'status' => 'menunggu',
        ]);
        
        // Buat monitoring otomatis
        MonitoringPelanggaran::create([
            'pelanggaran_id' => $pelanggaran->id,
            'status' => 'baru',
            'catatan' => 'Pelanggaran baru dari kesiswaan: ' . auth()->user()->name,
        ]);
        
        return redirect()->route('kesiswaan.pelanggaran.index')->with('success', 'Pelanggaran berhasil ditambahkan dan menunggu verifikasi');
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $siswas = Siswa::all();
        $jenisPelanggarans = JenisPelanggaran::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        return view('kesiswaan.pelanggaran.edit', compact('pelanggaran', 'siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'keterangan' => 'nullable',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $pelanggaran->update([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('kesiswaan.pelanggaran.index')->with('success', 'Pelanggaran berhasil diupdate');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();
        return redirect()->route('kesiswaan.pelanggaran.index')->with('success', 'Pelanggaran berhasil dihapus');
    }
}
