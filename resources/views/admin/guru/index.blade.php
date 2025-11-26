@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Guru</h1>
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary mb-3">Tambah Guru</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <i class="fas fa-chalkboard-teacher me-1"></i>
            Data Guru
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>Bidang Studi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $key => $g)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $g->nip }}</td>
                        <td>{{ $g->nama_guru }}</td>
                        <td>{{ $g->bidang_studi }}</td>
                        <td>{{ $g->status }}</td>
                        <td>
                            <a href="{{ route('admin.guru.edit', $g->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" style="display:inline">
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
