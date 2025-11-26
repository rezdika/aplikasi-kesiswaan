<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPrestasi;
use Illuminate\Http\Request;

class JenisPrestasiController extends Controller
{
    public function index()
    {
        $jenisPrestasi = JenisPrestasi::latest()->get();
        return view('admin.jenis-prestasi.index', compact('jenisPrestasi'));
    }

    public function create()
    {
        return view('admin.jenis-prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:150',
            'poin' => 'required|integer',
            'kategori' => 'nullable|string|max:100',
            'penghargaan' => 'nullable|string|max:150',
        ]);

        JenisPrestasi::create($request->all());

        return redirect()->route('admin.jenis-prestasi.index')->with('success', 'Jenis prestasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenisPrestasi = JenisPrestasi::findOrFail($id);
        return view('admin.jenis-prestasi.edit', compact('jenisPrestasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:150',
            'poin' => 'required|integer',
            'kategori' => 'nullable|string|max:100',
            'penghargaan' => 'nullable|string|max:150',
        ]);

        $jenisPrestasi = JenisPrestasi::findOrFail($id);
        $jenisPrestasi->update($request->all());

        return redirect()->route('admin.jenis-prestasi.index')->with('success', 'Jenis prestasi berhasil diupdate');
    }

    public function destroy($id)
    {
        $jenisPrestasi = JenisPrestasi::findOrFail($id);
        $jenisPrestasi->delete();
        return redirect()->route('admin.jenis-prestasi.index')->with('success', 'Jenis prestasi berhasil dihapus');
    }
}
