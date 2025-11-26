@extends('admin.layouts.app')

@section('title', 'Tambah Orangtua')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Orangtua</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orangtua.index') }}">Data Orangtua</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Orangtua
        </div>
        <div class="card-body">
            <form action="{{ route('admin.orangtua.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="siswa_id" class="form-label">Siswa</label>
                    <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="hubungan" class="form-label">Hubungan</label>
                    <select class="form-select @error('hubungan') is-invalid @enderror" id="hubungan" name="hubungan" required>
                        <option value="">Pilih Hubungan</option>
                        <option value="ayah" {{ old('hubungan') == 'ayah' ? 'selected' : '' }}>Ayah</option>
                        <option value="ibu" {{ old('hubungan') == 'ibu' ? 'selected' : '' }}>Ibu</option>
                        <option value="wali" {{ old('hubungan') == 'wali' ? 'selected' : '' }}>Wali</option>
                    </select>
                    @error('hubungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_orangtua" class="form-label">Nama Orangtua</label>
                    <input type="text" class="form-control @error('nama_orangtua') is-invalid @enderror" 
                           id="nama_orangtua" name="nama_orangtua" value="{{ old('nama_orangtua') }}" required>
                    @error('nama_orangtua')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
                           id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required>
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pendidikan" class="form-label">Pendidikan</label>
                    <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" 
                           id="pendidikan" name="pendidikan" value="{{ old('pendidikan') }}" required>
                    @error('pendidikan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telepon</label>
                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" 
                           id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
                    @error('no_telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.orangtua.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection