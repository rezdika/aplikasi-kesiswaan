@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Jenis Sanksi</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.jenis-sanksi.update', $jenisSanksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Jenis Sanksi</label>
                    <input type="text" name="jenis_sanksi" class="form-control @error('jenis_sanksi') is-invalid @enderror" value="{{ old('jenis_sanksi', $jenisSanksi->jenis_sanksi) }}" required>
                    @error('jenis_sanksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $jenisSanksi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.jenis-sanksi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
