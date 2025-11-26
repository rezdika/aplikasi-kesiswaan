@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Pelaksanaan Sanksi</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            <i class="fas fa-edit me-1"></i>
            Form Edit Pelaksanaan Sanksi
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Siswa:</strong> {{ $pelaksanaanSanksi->sanksi?->pelanggaran?->siswa?->nama_siswa ?? '-' }}<br>
                <strong>Pelanggaran:</strong> {{ $pelaksanaanSanksi->sanksi?->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }}<br>
                <strong>Sanksi:</strong> {{ $pelaksanaanSanksi->sanksi?->jenisSanksi?->nama_sanksi ?? '-' }}
            </div>
            
            <form action="{{ route('walas.pelaksanaan-sanksi.update', $pelaksanaanSanksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="belum_selesai" {{ $pelaksanaanSanksi->status == 'belum_selesai' ? 'selected' : '' }}>Belum Selesai</option>
                        <option value="selesai" {{ $pelaksanaanSanksi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pelaksanaanSanksi->tanggal_selesai) }}">
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $pelaksanaanSanksi->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('walas.pelaksanaan-sanksi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection