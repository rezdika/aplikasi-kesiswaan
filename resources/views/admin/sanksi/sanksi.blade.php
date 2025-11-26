@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">View Data Sanksi</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Pelanggaran</th>
                        <th>Jenis Sanksi</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sanksi as $key => $s)
                    <tr>
                        <td>{{ $sanksi->firstItem() + $key }}</td>
                        <td>{{ $s->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                        <td>{{ $s->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        <td>{{ $s->jenisSanksi->nama_sanksi ?? '-' }}</td>
                        <td>{{ $s->catatan ?? '-' }}</td>
                        <td>
                            @php
                                $badgeClass = match($s->status) {
                                    'berjalan' => 'primary',
                                    'selesai' => 'success',
                                    'direncanakan' => 'secondary',
                                    'ditunda' => 'warning',
                                    'dibatalkan' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">
                                {{ ucfirst($s->status ?? 'direncanakan') }}
                            </span>
                        </td>
                        <td>{{ $s->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data sanksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection