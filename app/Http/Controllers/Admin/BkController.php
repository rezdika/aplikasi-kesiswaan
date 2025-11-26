<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;

class BkController extends Controller
{
    public function index()
    {
        $bks = BimbinganKonseling::with(['siswa', 'bk', 'pelanggaran.jenisPelanggaran'])->latest()->paginate(10);
        return view('admin.bk.bk', compact('bks'));
    }
}