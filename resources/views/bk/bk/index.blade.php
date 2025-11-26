@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Bimbingan Konseling</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Pelanggaran Siswa yang Sudah Melaksanakan Sanksi
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Tanggal</th>
                        <th>Status Bimbingan Konseling</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggarans as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->siswa->nama_siswa }}</td>
                        <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $p->jenisPelanggaran->nama }}</td>
                        <td>{{ $p->created_at->format('d-m-Y') }}</td>
                        <td>
                            @if($p->bimbinganKonseling)
                                @php
                                    $badgeClass = match($p->bimbinganKonseling->status) {
                                        'selesai' => 'success',
                                        'diproses' => 'warning', 
                                        'tindak_lanjut' => 'info',
                                        'terdaftar' => 'secondary',
                                        default => 'secondary'
                                    };
                                    $statusText = match($p->bimbinganKonseling->status) {
                                        'terdaftar' => 'Terdaftar',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                        'tindak_lanjut' => 'Tindak Lanjut',
                                        default => ucfirst($p->bimbinganKonseling->status)
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                            @else
                                <span class="badge bg-danger">Belum Ditangani</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('bk.bk.create', ['pelanggaran_id' => $p->id]) }}" class="btn btn-sm btn-primary">Pilih</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada pelanggaran yang perlu ditindaklanjuti</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
