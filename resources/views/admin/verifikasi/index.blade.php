@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Verifikasi Data</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Verifikasi Pelanggaran -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Verifikasi Pelanggaran</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggaran</th>
                        <th>Siswa</th>
                        <th>Sanksi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($verifikasis->where('pelanggaran_id', '!=', null) as $v)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $v->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}</td>
                        <td>{{ $v->siswa?->nama_siswa ?? '-' }}</td>
                        <td>
                            @if($v->pelanggaran && $v->pelanggaran->sanksi && $v->pelanggaran->sanksi->count() > 0)
                                @foreach($v->pelanggaran->sanksi as $sanksi)
                                    <span class="badge bg-secondary mb-1">{{ $sanksi->jenisSanksi?->nama_sanksi ?? $sanksi->jenis_sanksi ?? 'Sanksi' }}</span><br>
                                @endforeach
                            @else
                                <span class="text-muted">Belum ada sanksi</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $v->status == 'diverifikasi' ? 'success' : ($v->status == 'ditolak' ? 'danger' : ($v->status == 'direvisi' ? 'info' : 'warning')) }}">
                                {{ ucfirst($v->status) }}
                            </span>
                        </td>
                        <td>
                            @if($v->status == 'menunggu' || $v->status == 'direvisi')
                                <form action="{{ route('admin.verifikasi.update', $v->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="diverifikasi">
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.verifikasi.update', $v->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                                <form action="{{ route('admin.verifikasi.update', $v->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="direvisi">
                                    <button type="submit" class="btn btn-sm btn-info">Revisi</button>
                                </form>
                            @else
                                <span class="text-muted">Sudah diproses</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pelanggaran untuk diverifikasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection