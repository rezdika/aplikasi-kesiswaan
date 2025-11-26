@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Sanksi</h1>
    <div class="alert alert-info mb-3">
        <i class="fas fa-info-circle me-2"></i>
        Sanksi otomatis dibuat saat verifikasi pelanggaran berdasarkan total poin siswa. Anda hanya perlu mengubah status sanksi.
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            <i class="fas fa-gavel me-1"></i>
            Data Sanksi
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-warning">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Pelanggaran</th>
                        <th>Jenis Sanksi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sanksi as $key => $s)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $s->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                        <td>{{ $s->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        <td>{{ $s->jenisSanksi->nama_sanksi }}</td>
                        <td>{{ $s->tanggal_mulai }}</td>
                        <td>{{ $s->tanggal_selesai }}</td>
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
                                {{ ucfirst($s->status) }}
                            </span>
                            @if($s->pelaksanaanSanksi)
                                <br><small class="text-muted">Pelaksanaan: {{ ucfirst($s->pelaksanaanSanksi->status) }}</small>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kesiswaan.sanksi.show', $s->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('kesiswaan.sanksi.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @if($s->pelanggaran)
                            <a href="{{ route('kesiswaan.export.surat-sanksi', $s->pelanggaran->id) }}" class="btn btn-sm btn-success" target="_blank">
                                <i class="fas fa-print"></i> Surat
                            </a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $sanksi->links() }}
        </div>
    </div>
</div>
@endsection