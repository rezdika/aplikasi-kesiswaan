@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Kelas</h1>
    <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary mb-3">Tambah Kelas</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Jurusan</th>
                        <th>Wali Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas as $key => $k)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->jurusan }}</td>
                        <td>{{ $k->guru->nama_guru ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display:inline">
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
