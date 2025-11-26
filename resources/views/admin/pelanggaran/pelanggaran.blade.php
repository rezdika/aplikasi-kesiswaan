@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">View Data Pelanggaran</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Keterangan</th>
                        <th>Guru Pencatat</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggarans as $key => $p)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $p->jenisPelanggaran->nama ?? '-' }}</td>
                        <td>{{ $p->poin }}</td>
                        <td>{{ $p->keterangan ?? '-' }}</td>
                        <td>{{ $p->guru->guru->nama_guru ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $p->terverifikasi ? 'success' : 'warning' }}">
                                {{ $p->terverifikasi ? 'Terverifikasi' : 'Menunggu' }}
                            </span>
                        </td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pelanggaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection