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
                        <th>Kelas</th>
                        <th>Pelanggaran</th>
                        <th>Sanksi</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelaksanaanSanksis as $key => $ps)
                    <tr>
                        <td>{{ ($pelaksanaanSanksis->currentPage() - 1) * $pelaksanaanSanksis->perPage() + $key + 1 }}</td>
                        <td>{{ $ps->sanksi?->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                        <td>{{ $ps->sanksi?->pelanggaran?->siswa?->kelas?->nama_kelas ?? '-' }}</td>
                        <td>{{ $ps->sanksi?->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        <td>{{ $ps->sanksi?->jenisSanksi?->nama_sanksi ?? '-' }}</td>
                        <td>{{ $ps->tanggal_pelaksanaan ? \Carbon\Carbon::parse($ps->tanggal_pelaksanaan)->format('d/m/Y') : '-' }}</td>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data pelaksanaan sanksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $pelaksanaanSanksis->links() }}
        </div>
    </div>
</div>
@endsection