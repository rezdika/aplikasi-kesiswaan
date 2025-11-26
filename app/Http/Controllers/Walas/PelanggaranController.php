<?php

namespace App\Http\Controllers\Walas;

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
        $kelasId = auth()->user()->guru->kelas->id;
        $pelanggarans = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guru', 'verifikasi'])
            ->whereHas('siswa', function($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->latest()->get();
        return view('walas.pelanggaran.index', compact('pelanggarans'));
    }

    public function create()
    {
        $kelasId = auth()->user()->guru->kelas->id;
        $siswas = Siswa::where('kelas_id', $kelasId)->get();
        $jenisPelanggarans = JenisPelanggaran::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        return view('walas.pelanggaran.create', compact('siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
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
        
        // Validasi siswa harus dari kelas yang sama
        $siswa = Siswa::findOrFail($request->siswa_id);
        if ($siswa->kelas_id !== auth()->user()->guru->kelas->id) {
            return redirect()->back()->with('error', 'Anda hanya bisa menginput pelanggaran untuk siswa di kelas Anda.');
        }

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
            'catatan' => 'Pelanggaran baru dari wali kelas: ' . auth()->user()->name,
        ]);
        
        return redirect()->route('walas.pelanggaran.index')->with('success', 'Pelanggaran berhasil ditambahkan dan menunggu verifikasi');
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        // Validasi pelanggaran harus dari siswa di kelas yang sama
        if ($pelanggaran->siswa->kelas_id !== auth()->user()->guru->kelas->id) {
            abort(403, 'Anda hanya bisa mengedit pelanggaran siswa di kelas Anda.');
        }

        $kelasId = auth()->user()->guru->kelas->id;
        $siswas = Siswa::where('kelas_id', $kelasId)->get();
        $jenisPelanggarans = JenisPelanggaran::all();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        return view('walas.pelanggaran.edit', compact('pelanggaran', 'siswas', 'jenisPelanggarans', 'tahunAjaranAktif'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        // Validasi pelanggaran harus dari siswa di kelas yang sama
        if ($pelanggaran->siswa->kelas_id !== auth()->user()->guru->kelas->id) {
            abort(403, 'Anda hanya bisa mengedit pelanggaran siswa di kelas Anda.');
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'keterangan' => 'nullable',
        ]);

        // Validasi siswa harus dari kelas yang sama
        $siswa = Siswa::findOrFail($request->siswa_id);
        if ($siswa->kelas_id !== auth()->user()->guru->kelas->id) {
            return redirect()->back()->with('error', 'Anda hanya bisa menginput pelanggaran untuk siswa di kelas Anda.');
        }

        $jenisPelanggaran = JenisPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaranAktif = TahunAjaran::getAktif();
        
        $pelanggaran->update([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan
        ]);
        return redirect()->route('walas.pelanggaran.index')->with('success', 'Pelanggaran berhasil diupdate');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        // Validasi pelanggaran harus dari siswa di kelas yang sama
        if ($pelanggaran->siswa->kelas_id !== auth()->user()->guru->kelas->id) {
            abort(403, 'Anda hanya bisa menghapus pelanggaran siswa di kelas Anda.');
        }

        $pelanggaran->delete();
        return redirect()->route('walas.pelanggaran.index')->with('success', 'Pelanggaran berhasil dihapus');
    }

    public function revisi(Request $request, $id)
{
    $p = Pelanggaran::findOrFail($id);
    $p->status = 'direvisi';

    return redirect()->back()->with('success', 'Pelanggaran ditandai perlu revisi');
}

}