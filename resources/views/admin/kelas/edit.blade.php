@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Kelas</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kelas.update', $kela->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama Kelas</label>
                    <input type="text" name="nama_kelas" class="form-control" value="{{ $kela->nama_kelas }}" required>
                </div>
                <div class="mb-3">
                    <label>Jurusan</label>
                    <input type="text" name="jurusan" class="form-control" value="{{ $kela->jurusan }}" required>
                </div>
                <div class="mb-3">
                    <label>Wali Kelas</label>
                    <select name="guru_id" class="form-control">
                        <option value="">Pilih Wali Kelas (Optional)</option>
                        @foreach($guru as $guru)
                            <option value="{{ $guru->id }}" {{ $kela->guru_id == $guru->id ? 'selected' : '' }}>{{ $guru->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
