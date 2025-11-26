<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['guru', 'siswa', 'orangtuaUser'])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $guru = Guru::with('kelas')->get();
        $siswa = Siswa::all();
        $orangtua = Orangtua::all();
        return view('admin.users.create', compact('guru', 'siswa', 'orangtua'));
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'level' => 'required|in:admin,guru,kepsek,siswa,ortu,bk,wali_kelas,kesiswaan',
            'guru_id' => in_array($request->level, ['bk', 'guru', 'wali_kelas', 'kesiswaan', 'kepsek']) ? 'required|exists:guru,id' : 'nullable|exists:guru,id',
            'siswa_id' => $request->level == 'siswa' ? 'required|exists:siswa,id' : 'nullable|exists:siswa,id',
            'ortu_id' => $request->level == 'ortu' ? 'required|exists:orangtua,orangtua_id' : 'nullable|exists:orangtua,orangtua_id',
        ];

        $request->validate($rules);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'guru_id' => $request->guru_id,
            'siswa_id' => $request->level == 'siswa' ? $request->siswa_id : null,
            'ortu_id' => $request->level == 'ortu' ? $request->ortu_id : null,
            'can_verify' => $request->has('can_verify'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $guru = Guru::with('kelas')->get();
        $siswa = Siswa::all();
        $orangtua = Orangtua::all();
        return view('admin.users.edit', compact('user', 'guru', 'siswa', 'orangtua'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'username' => 'required|unique:users,username,' . $user->id,
            'level' => 'required|in:admin,guru,kepsek,siswa,ortu,bk,wali_kelas,kesiswaan',
            'guru_id' => in_array($request->level, ['bk', 'guru', 'wali_kelas', 'kesiswaan', 'kepsek']) ? 'required|exists:guru,id' : 'nullable|exists:guru,id',
            'siswa_id' => $request->level == 'siswa' ? 'required|exists:siswa,id' : 'nullable|exists:siswa,id',
            'ortu_id' => $request->level == 'ortu' ? 'required|exists:orangtua,orangtua_id' : 'nullable|exists:orangtua,orangtua_id',
        ];

        $request->validate($rules);

        $data = [
            'username' => $request->username,
            'level' => $request->level,
            'guru_id' => $request->guru_id,
            'siswa_id' => $request->level == 'siswa' ? $request->siswa_id : null,
            'ortu_id' => $request->level == 'ortu' ? $request->ortu_id : null,
            'can_verify' => $request->has('can_verify'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
