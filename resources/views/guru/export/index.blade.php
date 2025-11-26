@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Export Laporan</h1>

    <!-- Menu Export -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Export Laporan Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda hanya dapat melihat dan export data pelanggaran yang Anda catat sendiri.
                    </div>
                    <form action="{{ route('guru.export.pelanggaran') }}" method="GET" target="_blank">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="form-control">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-danger w-100">Export Pelanggaran</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pelanggaran -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Data Pelanggaran Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                            <th>Tanggal</th>
                            <th>Guru Pencatat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggarans as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                            <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                            <td>{{ $p->poin }}</td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                            <td>{{ $p->guru->guru->nama_guru ?? '-' }}</td>
                            <td>
                                <a href="{{ route('guru.export.surat-sanksi', $p->id) }}" 
                                   class="btn btn-sm btn-warning" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Surat Sanksi
                                </a>
                            </td>
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
</div>
@endsection
