@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Jenis Pelanggaran</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.jenis-pelanggaran.update', $jenisPelanggaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama Pelanggaran</label>
                    <input type="text" name="nama_pelanggaran" class="form-control" value="{{ $jenisPelanggaran->nama_pelanggaran }}" required>
                </div>
                <div class="mb-3">
                    <label>Poin</label>
                    <input type="number" name="poin" class="form-control" value="{{ $jenisPelanggaran->poin }}" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="">Pilih Kategori</option>
                        <option value="Ringan" {{ $jenisPelanggaran->kategori == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                        <option value="Sedang" {{ $jenisPelanggaran->kategori == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Berat" {{ $jenisPelanggaran->kategori == 'Berat' ? 'selected' : '' }}>Berat</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Sanksi Rekomendasi</label>
                    <textarea name="sanksi_rekomendasi" class="form-control" rows="3" placeholder="Masukkan rekomendasi sanksi">{{ old('sanksi_rekomendasi', $jenisPelanggaran->sanksi_rekomendasi) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
