<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;
use Illuminate\Http\Request;

class PelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $pelaksanaanSanksis = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa.kelas', 'sanksi.pelanggaran.jenisPelanggaran', 'sanksi.jenisSanksi'])
            ->whereHas('sanksi.pelanggaran')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.pelaksanaan-sanksi.index', compact('pelaksanaanSanksis'));
    }


}
