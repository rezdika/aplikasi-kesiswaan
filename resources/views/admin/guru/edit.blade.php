@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Guru</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}" required>
                </div>
                <div class="mb-3">
                    <label>Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-control" value="{{ $guru->nama_guru }}" required>
                </div>
                <div class="mb-3">
                    <label>Bidang Studi</label>
                    <input type="text" name="bidang_studi" class="form-control" value="{{ $guru->bidang_studi }}" required>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" {{ $guru->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ $guru->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
