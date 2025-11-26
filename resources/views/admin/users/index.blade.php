@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manage User</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Tambah User</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Guru</th>
                        <th>Siswa</th>
                        <th>Orangtua</th>
                        <th>Can Verify</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $u)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->level }}</td>
                        <td>{{ $u->guru->nama_guru ?? '-' }}</td>
                        <td>{{ $u->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $u->orangtuaUser->nama_orangtua ?? '-' }}</td>
                        <td>{{ $u->can_verify ? 'Ya' : 'Tidak' }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
