@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Sanksi</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-warning text-white">
            <i class="fas fa-edit me-1"></i>
            Form Edit Sanksi
        </div>
        <div class="card-body">
            <form action="{{ route('kesiswaan.sanksi.update', $sanksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Pelanggaran</label>
                    <div class="form-control-plaintext">
                        <strong>{{ $sanksi->pelanggaran?->siswa?->nama_siswa ?? '-' }}</strong> - {{ $sanksi->pelanggaran?->jenisPelanggaran?->nama_pelanggaran ?? '-' }} 
                        (Poin: {{ $sanksi->pelanggaran?->poin ?? 0 }}) - {{ $sanksi->pelanggaran?->created_at?->format('d/m/Y') ?? '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Sanksi</label>
                    <div class="form-control-plaintext">
                        <strong>{{ $sanksi->jenisSanksi->nama_sanksi }}</strong>
                        <br><small class="text-muted">Jenis sanksi otomatis berdasarkan total poin pelanggaran</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $sanksi->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Sanksi</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="direncanakan" {{ ($sanksi->status == 'direncanakan' || old('status') == 'direncanakan') ? 'selected' : '' }}>Direncanakan</option>
                        <option value="berjalan" {{ ($sanksi->status == 'berjalan' || old('status') == 'berjalan') ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ ($sanksi->status == 'selesai' || old('status') == 'selesai') ? 'selected' : '' }}>Selesai</option>
                        <option value="ditunda" {{ ($sanksi->status == 'ditunda' || old('status') == 'ditunda') ? 'selected' : '' }}>Ditunda</option>
                        <option value="dibatalkan" {{ ($sanksi->status == 'dibatalkan' || old('status') == 'dibatalkan') ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Jika diubah ke "Berjalan", pelaksanaan sanksi akan otomatis dibuat</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <div class="form-control-plaintext">{{ $sanksi->tanggal_mulai ? \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d/m/Y') : '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Target Selesai</label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $sanksi->tanggal_selesai) }}" required>
                            @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection