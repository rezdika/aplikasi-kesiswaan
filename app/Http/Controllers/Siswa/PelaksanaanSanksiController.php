<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PelaksanaanSanksi;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;

class PelaksanaanSanksiController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa_id;
        
        $pelaksanaanSanksis = PelaksanaanSanksi::with(['sanksi.pelanggaran.siswa', 'sanksi.pelanggaran.jenisPelanggaran', 'sanksi.jenisSanksi'])
            ->whereHas('sanksi.pelanggaran', function($query) use ($siswaId) {
                $query->where('siswa_id', $siswaId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('siswa.pelaksanaan-sanksi.index', compact('pelaksanaanSanksis'));
    }

    public function update(Request $request, PelaksanaanSanksi $pelaksanaanSanksi)
    {
        // Validasi hanya siswa yang bersangkutan yang bisa update
        if (!$pelaksanaanSanksi->sanksi?->pelanggaran || $pelaksanaanSanksi->sanksi->pelanggaran->siswa_id !== auth()->user()->siswa_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:terjadwal,dikerjakan,tuntas,perpanjangan',
            'tanggal_selesai' => 'nullable|date',
            'catatan' => 'nullable|string',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'bukti.required' => 'Foto bukti pelaksanaan sanksi wajib diupload',
            'bukti.image' => 'File harus berupa gambar',
            'bukti.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'bukti.max' => 'Ukuran foto maksimal 2MB'
        ]);

        $data = [
            'status' => $request->status,
            'catatan' => $request->catatan,
            'tanggal_selesai' => $request->tanggal_selesai
        ];

        // Upload foto bukti (wajib)
        $file = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti_sanksi'), $filename);
        $data['bukti'] = 'uploads/bukti_sanksi/' . $filename;

        $pelaksanaanSanksi->update($data);
        
        NotificationHelper::pelaksanaanSanksi($pelaksanaanSanksi);

        return redirect()->route('siswa.pelaksanaan-sanksi.index')
            ->with('success', 'Status pelaksanaan sanksi berhasil diupdate');
    }
}
