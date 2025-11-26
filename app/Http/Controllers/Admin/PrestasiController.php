<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.prestasi.prestasi', compact('prestasis'));
    }

}
