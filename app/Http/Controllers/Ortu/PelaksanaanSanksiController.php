<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use Illuminate\Http\Request;

class PelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $anakIds = collect();
        
        if ($user->orangtuaUser?->siswa) {
            $anakIds = collect([$user->orangtuaUser->siswa->id]);
        } elseif ($user->orangtua?->siswa) {
            $anakIds = collect([$user->orangtua->siswa->id]);
        }
        
        $pelaksanaanSanksis = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa', 'sanksi.pelanggaran.jenisPelanggaran', 'sanksi.jenisSanksi'])
            ->whereHas('sanksi.pelanggaran', function($query) use ($anakIds) {
                $query->whereIn('siswa_id', $anakIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('ortu.pelaksanaan-sanksi.index', compact('pelaksanaanSanksis'));
    }
}
