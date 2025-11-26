@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Jenis Prestasi</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.jenis-prestasi.update', $jenisPrestasi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" class="form-control @error('nama_prestasi') is-invalid @enderror" value="{{ old('nama_prestasi', $jenisPrestasi->nama_prestasi) }}" required>
                    @error('nama_prestasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Poin</label>
                    <input type="number" name="poin" class="form-control @error('poin') is-invalid @enderror" value="{{ old('poin', $jenisPrestasi->poin) }}" required>
                    @error('poin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $jenisPrestasi->kategori) }}">
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Penghargaan</label>
                    <input type="text" name="penghargaan" class="form-control @error('penghargaan') is-invalid @enderror" value="{{ old('penghargaan', $jenisPrestasi->penghargaan) }}">
                    @error('penghargaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.jenis-prestasi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
