@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Prestasi</h1>
    <a href="{{ route('kesiswaan.prestasi.create') }}" class="btn btn-primary mb-3">Tambah Prestasi</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <i class="fas fa-trophy me-1"></i>
            Data Prestasi
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Prestasi</th>
                        <th>Poin</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestasis as $key => $p)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $p->siswa->nama ?? '-' }}</td>
                        <td>{{ $p->jenisPrestasi->nama ?? '-' }}</td>
                        <td><span class="badge bg-success">{{ $p->poin }}</span></td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('kesiswaan.prestasi.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection