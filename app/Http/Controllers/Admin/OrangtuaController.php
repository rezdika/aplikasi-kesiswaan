<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orangtua;
use App\Models\Siswa;
use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function index()
    {
        $orangtua = Orangtua::with('siswa')->latest()->get();
        return view('admin.orangtua.index', compact('orangtua'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        return view('admin.orangtua.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|in:ayah,ibu,wali',
            'nama_orangtua' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        Orangtua::create(array_merge($request->all(), ['user_id' => null]));

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orangtua berhasil ditambahkan');
    }

    public function edit($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $siswa = Siswa::all();
        return view('admin.orangtua.edit', compact('orangtua', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $orangtua = Orangtua::findOrFail($id);
        
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'hubungan' => 'required|in:ayah,ibu,wali',
            'nama_orangtua' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        $orangtua->update(array_merge($request->all(), ['user_id' => null]));

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orangtua berhasil diperbarui');
    }

    public function destroy($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $orangtua->delete();
        return redirect()->route('admin.orangtua.index')->with('success', 'Data orangtua berhasil dihapus');
    }
}