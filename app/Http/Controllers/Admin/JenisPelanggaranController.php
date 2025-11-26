<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $jenisPelanggaran = JenisPelanggaran::all();
        return view('admin.jenis-pelanggaran.index', compact('jenisPelanggaran'));
    }

    public function create()
    {
        return view('admin.jenis-pelanggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|max:150',
            'poin' => 'required|integer',
            'kategori' => 'nullable|max:50',
            'sanksi_rekomendasi' => 'nullable|string',
        ]);

        $jenisPelanggaran = JenisPelanggaran::create($request->all());
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => 'JenisPelanggaran',
            'model_id' => $jenisPelanggaran->id,
            'description' => 'Menambahkan jenis pelanggaran: ' . $jenisPelanggaran->nama_pelanggaran,
        ]);
        
        return redirect()->route('admin.jenis-pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil ditambahkan');
    }

    public function edit(JenisPelanggaran $jenisPelanggaran)
    {
        return view('admin.jenis-pelanggaran.edit', compact('jenisPelanggaran'));
    }

    public function update(Request $request, JenisPelanggaran $jenisPelanggaran)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|max:150',
            'poin' => 'required|integer',
            'kategori' => 'nullable|max:50',
            'sanksi_rekomendasi' => 'nullable|string',
        ]);

        $jenisPelanggaran->update($request->all());
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => 'JenisPelanggaran',
            'model_id' => $jenisPelanggaran->id,
            'description' => 'Mengupdate jenis pelanggaran: ' . $jenisPelanggaran->nama_pelanggaran,
        ]);
        
        return redirect()->route('admin.jenis-pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil diupdate');
    }

    public function destroy(JenisPelanggaran $jenisPelanggaran)
    {
        $nama = $jenisPelanggaran->nama_pelanggaran;
        $jenisPelanggaran->delete();
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => 'JenisPelanggaran',
            'model_id' => null,
            'description' => 'Menghapus jenis pelanggaran: ' . $nama,
        ]);
        
        return redirect()->route('admin.jenis-pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil dihapus');
    }
}
