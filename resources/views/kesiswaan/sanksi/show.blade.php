@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Sanksi</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="fas fa-info-circle me-1"></i>
            Detail Sanksi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Siswa</th>
                            <td>: {{ $sanksi->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NIS</th>
                            <td>: {{ $sanksi->pelanggaran?->siswa?->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>: {{ $sanksi->pelanggaran?->siswa?->kelas?->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pelanggaran</th>
                            <td>: {{ $sanksi->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Poin Pelanggaran</th>
                            <td>: <span class="badge bg-danger">{{ $sanksi->pelanggaran?->poin ?? 0 }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Jenis Sanksi</th>
                            <td>: {{ $sanksi->jenisSanksi->nama_sanksi }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <td>: {{ $sanksi->tanggal_mulai }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Selesai</th>
                            <td>: {{ $sanksi->tanggal_selesai }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: 
                                @if($sanksi->pelaksanaanSanksi)
                                    @if($sanksi->pelaksanaanSanksi->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning">Belum Selesai</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Belum Dimulai</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ $sanksi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Deskripsi Sanksi:</h6>
                    <div class="alert alert-secondary">
                        <p>{{ $sanksi->catatan }}</p>
                    </div>
                </div>
            </div>

            @if($sanksi->pelaksanaanSanksi)
            <div class="row mt-3">
                <div class="col-12">
                    <h6>Detail Pelaksanaan:</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tanggal Mulai Pelaksanaan:</strong><br>
                                    {{ $sanksi->pelaksanaanSanksi->tanggal_mulai ?? '-' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Target Selesai:</strong><br>
                                    {{ $sanksi->pelaksanaanSanksi->tanggal_target_selesai ?? '-' }}
                                </div>
                            </div>
                            @if($sanksi->pelaksanaanSanksi->tanggal_selesai)
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Tanggal Selesai Aktual:</strong><br>
                                    {{ $sanksi->pelaksanaanSanksi->tanggal_selesai }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Keterangan:</strong><br>
                                    {{ $sanksi->pelaksanaanSanksi->keterangan ?? '-' }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('kesiswaan.sanksi.edit', $sanksi->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection