@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pelaksanaan Sanksi</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="fas fa-tasks me-1"></i>
            Data Pelaksanaan Sanksi
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Pelanggaran</th>
                        <th>Sanksi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelaksanaanSanksis as $key => $ps)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $ps->sanksi?->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                        <td>{{ $ps->sanksi?->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        <td>{{ $ps->sanksi?->jenisSanksi?->nama_sanksi ?? '-' }}</td>
                        <td>{{ $ps->tanggal_mulai ? \Carbon\Carbon::parse($ps->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $ps->tanggal_selesai ? \Carbon\Carbon::parse($ps->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($ps->bukti)
                                <a href="{{ asset($ps->bukti) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-image"></i> Lihat
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badgeClass = match($ps->status) {
                                    'tuntas' => 'success',
                                    'dikerjakan' => 'primary',
                                    'terjadwal' => 'secondary',
                                    'terlambat' => 'danger',
                                    'perpanjangan' => 'warning',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeClass }}">
                                {{ ucfirst($ps->status) }}
                            </span>
                        </td>
                        <td>{{ $ps->catatan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('kesiswaan.pelaksanaan-sanksi.edit', $ps->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data pelaksanaan sanksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection