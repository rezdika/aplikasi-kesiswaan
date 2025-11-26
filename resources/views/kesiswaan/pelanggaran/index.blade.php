@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Pelanggaran</h1>
    <a href="{{ route('kesiswaan.pelanggaran.create') }}" class="btn btn-primary mb-3">Tambah Pelanggaran</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-exclamation-triangle me-1"></i>
            Data Pelanggaran
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggarans as $key => $p)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $p->siswa->nama ?? '-' }}</td>
                        <td>{{ $p->jenisPelanggaran->nama ?? '-' }}</td>
                        <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($p->terverifikasi)
                                <span class="badge bg-success">Terverifikasi</span>
                            @elseif($p->verifikasi && $p->verifikasi->status == 'direvisi')
                                <span class="badge bg-info">Direvisi</span>
                            @elseif($p->verifikasi && $p->verifikasi->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning">Menunggu Verifikasi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kesiswaan.pelanggaran.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection