@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Pelanggaran</h1>
    <a href="{{ route('guru.pelanggaran.create') }}" class="btn btn-primary mb-3">Tambah Pelanggaran</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
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
                            @php
                                $status = $p->terverifikasi;
                                $badgeClass = match($status) {
                                    true => 'bg-success',
                                    false => 'bg-warning',
                                    null => 'bg-secondary',
                                    default => 'bg-secondary'
                                };
                                $statusText = match($status) {
                                    true => 'Terverifikasi',
                                    false => 'Ditolak',
                                    null => 'Menunggu',
                                    default => 'Menunggu'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                        </td>
                        <td>
                            @if($p->terverifikasi !== true)
                                <a href="{{ route('guru.pelanggaran.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection