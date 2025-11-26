@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pelaksanaan Sanksi</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Ada kesalahan dalam pengisian form:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggaran</th>
                        <th>Sanksi</th>

                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelaksanaanSanksis as $key => $ps)
                    <tr>
                        <td>{{ $key + 1 }}</td>
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
                        <td>
                            @if($ps->status != 'tuntas')
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#selesaiModal{{ $ps->id }}">
                                @if($ps->status == 'terjadwal')
                                    Tandai Selesai
                                @else
                                    Update Status
                                @endif
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="selesaiModal{{ $ps->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('siswa.pelaksanaan-sanksi.update', $ps->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Pelaksanaan Sanksi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="terjadwal" {{ $ps->status == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                                        <option value="dikerjakan" {{ $ps->status == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                                                        <option value="tuntas" {{ $ps->status == 'tuntas' ? 'selected' : '' }}>Tuntas</option>
                                                        <option value="perpanjangan" {{ $ps->status == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Selesai</label>
                                                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $ps->tanggal_selesai }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Upload Foto Bukti <span class="text-danger">*</span></label>
                                                    <input type="file" name="bukti" class="form-control @error('bukti') is-invalid @enderror" accept="image/*" required>
                                                    @error('bukti')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">Format: JPG, JPEG, PNG. Max: 2MB. <strong>Wajib diisi!</strong></small>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Catatan (Opsional)</label>
                                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Jelaskan pelaksanaan sanksi...">{{ $ps->catatan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pelaksanaan sanksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
