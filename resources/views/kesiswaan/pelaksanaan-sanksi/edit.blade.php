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
            
            <form action="{{ route('kesiswaan.pelaksanaan-sanksi.update', $pelaksanaanSanksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="terjadwal" {{ $pelaksanaanSanksi->status == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="dikerjakan" {{ $pelaksanaanSanksi->status == 'dikerjakan' ? 'selected' : '' }}>Dikerjakan</option>
                        <option value="tuntas" {{ $pelaksanaanSanksi->status == 'tuntas' ? 'selected' : '' }}>Tuntas</option>
                        <option value="terlambat" {{ $pelaksanaanSanksi->status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        <option value="perpanjangan" {{ $pelaksanaanSanksi->status == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                    <input type="date" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $pelaksanaanSanksi->tanggal_pelaksanaan) }}">
                    @error('tanggal_pelaksanaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $pelaksanaanSanksi->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kesiswaan.pelaksanaan-sanksi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection