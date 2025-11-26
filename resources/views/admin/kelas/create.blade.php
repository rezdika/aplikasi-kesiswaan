@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Kelas</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jurusan</label>
                    <input type="text" name="jurusan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Wali Kelas</label>
                    <select name="guru_id" class="form-control">
                        <option value="">Pilih Wali Kelas (Optional)</option>
                        @foreach($guru as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
