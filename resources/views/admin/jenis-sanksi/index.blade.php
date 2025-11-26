@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Jenis Sanksi</h1>
    <a href="{{ route('admin.jenis-sanksi.create') }}" class="btn btn-primary mb-3">Tambah Jenis Sanksi</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Sanksi</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisSanksi as $key => $js)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $js->nama_sanksi }}</td>
                        <td>{{ $js->deskripsi ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.jenis-sanksi.edit', $js->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.jenis-sanksi.destroy', $js->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data jenis sanksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
