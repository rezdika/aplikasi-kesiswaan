@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Sanksi</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Sanksi
        </div>
        <div class="card-body">
            <form action="{{ route('kesiswaan.sanksi.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="pelanggaran_id" class="form-label">Pelanggaran Terverifikasi</label>
                    <select class="form-select @error('pelanggaran_id') is-invalid @enderror" id="pelanggaran_id" name="pelanggaran_id" required>
                        <option value="">Pilih Pelanggaran</option>
                        @foreach($pelanggaranTerverifikasi as $p)
                            <option value="{{ $p->id }}" {{ old('pelanggaran_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama_pelanggaran }} (Poin: {{ $p->poin }}) - {{ $p->created_at->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('pelanggaran_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_sanksi_id" class="form-label">Jenis Sanksi</label>
                    <select class="form-select @error('jenis_sanksi_id') is-invalid @enderror" id="jenis_sanksi_id" name="jenis_sanksi_id" required>
                        <option value="">Pilih Jenis Sanksi</option>
                        @foreach($jenisSanksi as $js)
                            <option value="{{ $js->id }}" {{ old('jenis_sanksi_id') == $js->id ? 'selected' : '' }}>
                                {{ $js->nama_sanksi }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_sanksi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Sanksi</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="direncanakan" {{ old('status') == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditunda" {{ old('status') == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
                        <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Jika status "Berjalan", pelaksanaan sanksi akan otomatis dibuat</small>
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Target Selesai</label>
                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Tanggal mulai akan diset otomatis ke hari ini</small>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection