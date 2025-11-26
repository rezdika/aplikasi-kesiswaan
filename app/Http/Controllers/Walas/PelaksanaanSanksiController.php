<?php

namespace App\Http\Controllers\Walas;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use App\Models\Sanksi;
use Illuminate\Http\Request;

class PelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('guru.kelas');
        
        if (!$user->guru || !$user->guru->kelas) {
            return view('walas.pelaksanaan-sanksi.index', ['pelaksanaanSanksis' => collect()]);
        }
        
        $kelasId = $user->guru->kelas->id;
        
        $pelaksanaanSanksis = PelaksanaanSanksi::whereHas('sanksi.pelanggaran.siswa', function($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->with([
                'sanksi' => function($query) {
                    $query->with([
                        'pelanggaran' => function($q) {
                            $q->with(['siswa.kelas', 'jenisPelanggaran']);
                        },
                        'jenisSanksi'
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('walas.pelaksanaan-sanksi.index', compact('pelaksanaanSanksis'));
    }


}
