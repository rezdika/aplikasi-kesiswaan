<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\TahunAjaran;
use App\Models\VerifikasiData;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::with(['siswa', 'jenisPelanggaran', 'guru', 'verifikasi'])->latest()->get();
        return view('admin.pelanggaran.pelanggaran', compact('pelanggarans'));
    }


    public function revisi(Request $request, $id)
{
    $p = Pelanggaran::findOrFail($id);
    $p->status = 'direvisi';

    return redirect()->back()->with('success', 'Pelanggaran ditandai perlu revisi');
}

}