@extends('admin.layouts.app')

@section('title', 'Tambah Tahun Ajaran')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Tahun Ajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tahun-ajaran.index') }}">Tahun Ajaran</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Tahun Ajaran
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                           id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" 
                           placeholder="Contoh: 2023/2024" required>
                    @error('tahun_ajaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                        <option value="">Pilih Semester</option>
                        <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>1 (Ganjil)</option>
                        <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>2 (Genap)</option>
                    </select>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status_aktif" name="status_aktif" value="1" {{ old('status_aktif') ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_aktif">
                            Aktif (Jika dicentang, tahun ajaran lain akan menjadi tidak aktif)
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection