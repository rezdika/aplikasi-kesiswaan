<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSanksi;
use Illuminate\Http\Request;

class JenisSanksiController extends Controller
{
    public function index()
    {
        $jenisSanksi = JenisSanksi::all();
        return view('admin.jenis-sanksi.index', compact('jenisSanksi'));
    }

    public function create()
    {
        return view('admin.jenis-sanksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sanksi' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        JenisSanksi::create($request->all());

        return redirect()->route('admin.jenis-sanksi.index')
            ->with('success', 'Jenis sanksi berhasil ditambahkan.');
    }

    public function edit(JenisSanksi $jenisSanksi)
    {
        return view('admin.jenis-sanksi.edit', compact('jenisSanksi'));
    }

    public function update(Request $request, JenisSanksi $jenisSanksi)
    {
        $request->validate([
            'nama_sanksi' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $jenisSanksi->update($request->all());

        return redirect()->route('admin.jenis-sanksi.index')
            ->with('success', 'Jenis sanksi berhasil diperbarui.');
    }

    public function destroy(JenisSanksi $jenisSanksi)
    {
        $jenisSanksi->delete();

        return redirect()->route('admin.jenis-sanksi.index')
            ->with('success', 'Jenis sanksi berhasil dihapus.');
    }
}