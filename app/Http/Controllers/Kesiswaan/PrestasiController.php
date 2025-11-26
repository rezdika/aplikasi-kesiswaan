<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\JenisPrestasi;
use App\Models\TahunAjaran;
use App\Models\Guru;
use App\Models\VerifikasiData;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::with(['siswa', 'jenisPrestasi', 'guru.guru', 'verifikasi'])->latest()->get();
        return view('kesiswaan.prestasi.index', compact('prestasis'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $jenisPrestasis = JenisPrestasi::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        $guru = Guru::all();
        return view('kesiswaan.prestasi.create', compact('siswas', 'jenisPrestasis', 'tahunAjaranAktif', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'keterangan' => 'nullable',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($request->jenis_prestasi_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $prestasi = Prestasi::create([
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPrestasi->poin,
            'keterangan' => $request->keterangan,
            'guru_id' => auth()->id(),
            'terverifikasi' => false
        ]);

        return redirect()->route('kesiswaan.prestasi.index')->with('success', 'Prestasi berhasil ditambahkan');
    }

    public function edit(Prestasi $prestasi)
    {
        $siswas = Siswa::all();
        $jenisPrestasis = JenisPrestasi::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        $guru = Guru::all();
        return view('kesiswaan.prestasi.edit', compact('prestasi', 'siswas', 'jenisPrestasis', 'tahunAjaranAktif', 'guru'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_prestasi_id' => 'required|exists:jenis_prestasi,id',
            'keterangan' => 'nullable',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($request->jenis_prestasi_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $prestasi->update([
            'siswa_id' => $request->siswa_id,
            'jenis_prestasi_id' => $request->jenis_prestasi_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPrestasi->poin,
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('kesiswaan.prestasi.index')->with('success', 'Prestasi berhasil diupdate');
    }

    public function destroy(Prestasi $prestasi)
    {
        $prestasi->delete();
        return redirect()->route('kesiswaan.prestasi.index')->with('success', 'Prestasi berhasil dihapus');
    }
}
