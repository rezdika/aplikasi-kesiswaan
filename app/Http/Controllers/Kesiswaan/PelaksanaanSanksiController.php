<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use Illuminate\Http\Request;

class PelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $pelaksanaanSanksis = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa', 'sanksi.pelanggaran.jenisPelanggaran', 'sanksi.jenisSanksi'])
            ->whereHas('sanksi.pelanggaran')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('kesiswaan.pelaksanaan-sanksi.index', compact('pelaksanaanSanksis'));
    }

    public function edit(PelaksanaanSanksi $pelaksanaanSanksi)
    {
        $pelaksanaanSanksi->load(['sanksi.pelanggaran.siswa', 'sanksi.pelanggaran.jenisPelanggaran', 'sanksi.jenisSanksi']);
        return view('kesiswaan.pelaksanaan-sanksi.edit', compact('pelaksanaanSanksi'));
    }

    public function update(Request $request, PelaksanaanSanksi $pelaksanaanSanksi)
    {
        $request->validate([
            'status' => 'required|in:terjadwal,dikerjakan,tuntas,terlambat,perpanjangan',
            'catatan' => 'nullable|string',
            'tanggal_pelaksanaan' => 'nullable|date',
        ]);

        $updateData = [
            'status' => $request->status,
            'catatan' => $request->catatan,
        ];

        if ($request->tanggal_pelaksanaan) {
            $updateData['tanggal_pelaksanaan'] = $request->tanggal_pelaksanaan;
        }

        $pelaksanaanSanksi->update($updateData);

        return redirect()->route('kesiswaan.pelaksanaan-sanksi.index')
            ->with('success', 'Status pelaksanaan sanksi berhasil diperbarui.');
    }
}