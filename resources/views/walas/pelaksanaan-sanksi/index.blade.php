@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pelaksanaan Sanksi Siswa Kelas</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(!auth()->user()->guru || !auth()->user()->guru->kelas)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Anda belum ditugaskan sebagai wali kelas. Silakan hubungi administrator untuk penugasan kelas.
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Menampilkan data pelaksanaan sanksi untuk kelas: <strong>{{ auth()->user()->guru->kelas->nama_kelas }}</strong>
        </div>
    @endif

    <div class="card mb-4">
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
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelaksanaanSanksis as $key => $ps)
                    @if($ps && $ps->sanksi && $ps->sanksi->pelanggaran && $ps->sanksi->pelanggaran->siswa)
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
                        <td>{{ $ps->keterangan ?? '-' }}</td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            @if(!auth()->user()->guru || !auth()->user()->guru->kelas)
                                Anda belum ditugaskan sebagai wali kelas
                            @else
                                Tidak ada data pelaksanaan sanksi untuk kelas Anda
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
