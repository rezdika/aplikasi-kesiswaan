<?php

namespace App\Http\Controllers\Bk;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class BkController extends Controller
{
    public function index()
    {
        $bks = BimbinganKonseling::with(['siswa', 'bk', 'pelanggaran.jenisPelanggaran'])->latest()->get();
        $pelanggarans = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->where('terverifikasi', true)
            ->whereHas('sanksi.pelaksanaanSanksi', function($query) {
                $query->where('status', 'tuntas');
            })
            ->latest()->get();
        return view('bk.bk.index', compact('bks', 'pelanggarans'));
    }

    public function create(Request $request)
    {
        $selectedPelanggaran = null;
        if ($request->has('pelanggaran_id')) {
            $selectedPelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
                ->find($request->pelanggaran_id);
        }
        
        return view('bk.bk.create', compact('selectedPelanggaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'tindakan' => 'required',
            'status' => 'nullable|in:terdaftar,diproses,selesai,tindak_lanjut',
        ]);

        $data = array_merge($request->all(), [
            'bk_id' => auth()->id(),
            'status' => $request->status ?? 'terdaftar'
        ]);
        
        BimbinganKonseling::create($data);
        return redirect()->route('bk.bk.index')->with('success', 'Data BK berhasil ditambahkan');
    }

    public function edit(BimbinganKonseling $bk)
    {
        $pelanggarans = Pelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->where('terverifikasi', true)
            ->whereHas('sanksi.pelaksanaanSanksi', function($query) {
                $query->where('status', 'tuntas');
            })
            ->latest()->get();
        return view('bk.bk.edit', compact('bk', 'pelanggarans'));
    }



    public function update(Request $request, BimbinganKonseling $bk)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'tindakan' => 'required',
            'status' => 'required|in:terdaftar,diproses,selesai,tindak_lanjut',
        ]);

        $bk->update($request->all());
        return redirect()->route('bk.bk.index')->with('success', 'Data BK berhasil diupdate');
    }

    public function destroy(BimbinganKonseling $bk)
    {
        $bk->delete();
        return redirect()->route('bk.bk.index')->with('success', 'Data BK berhasil dihapus');
    }
}
