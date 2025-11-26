@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Jenis Pelanggaran</h1>
    <a href="{{ route('admin.jenis-pelanggaran.create') }}" class="btn btn-primary mb-3">Tambah Jenis Pelanggaran</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggaran</th>
                        <th>Sanksi Rekomendasi</th>
                        <th>Kategori</th>
                        <th>Poin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisPelanggaran as $key => $jp)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $jp->nama_pelanggaran }}</td>
                        <td>{{ $jp->sanksi->jenis_sanksi ?? '-' }}</td>
                        <td>{{ $jp->kategori }}</td>
                        <td>{{ $jp->poin }}</td>
                        <td>
                            <a href="{{ route('admin.jenis-pelanggaran.edit', $jp->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.jenis-pelanggaran.destroy', $jp->id) }}" method="POST" style="display:inline">
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
