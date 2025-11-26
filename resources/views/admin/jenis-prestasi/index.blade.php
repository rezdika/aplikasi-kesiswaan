@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Jenis Prestasi</h1>
    <a href="{{ route('admin.jenis-prestasi.create') }}" class="btn btn-primary mb-3">Tambah Jenis Prestasi</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Prestasi</th>
                        <th>Poin</th>
                        <th>Kategori</th>
                        <th>Penghargaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisPrestasi as $key => $jp)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $jp->nama_prestasi }}</td>
                        <td>{{ $jp->poin }}</td>
                        <td>{{ $jp->kategori ?? '-' }}</td>
                        <td>{{ $jp->penghargaan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.jenis-prestasi.edit', $jp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.jenis-prestasi.destroy', $jp->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data jenis prestasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
