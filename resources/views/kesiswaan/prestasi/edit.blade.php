@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Prestasi</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.prestasi.update', $prestasi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Siswa</label>
                    <select name="siswa_id" class="form-control" required>
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}" {{ $prestasi->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama_siswa }} : {{ $s->kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Jenis Prestasi</label>
                    <select name="jenis_prestasi_id" class="form-control" required>
                        @foreach($jenisPrestasis as $jp)
                            <option value="{{ $jp->id }}" {{ $prestasi->jenis_prestasi_id == $jp->id ? 'selected' : '' }}>{{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)</option>
                        @endforeach
                    </select>
                </div>
                @if($tahunAjaranAktif)
                <div class="mb-3">
                    <label>Tahun Ajaran</label>
                    <input type="text" class="form-control" value="{{ $tahunAjaranAktif->tahun_ajaran }} - Semester {{ $tahunAjaranAktif->semester }}" readonly style="background-color: #e9ecef;">
                    <small class="text-muted">Tahun ajaran aktif akan digunakan secara otomatis</small>
                </div>
                @else
                <div class="alert alert-warning">
                    <strong>Peringatan!</strong> Tidak ada tahun ajaran yang aktif. Silakan aktifkan tahun ajaran terlebih dahulu.
                </div>
                @endif
                <div class="mb-3">
                    <label>Poin</label>
                    <input type="number" name="poin" class="form-control" value="{{ $prestasi->poin }}" required>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ $prestasi->keterangan }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Status Verifikasi</label>
                    <select name="status_verifikasi" class="form-control">
                        <option value="0" {{ !$prestasi->status_verifikasi ? 'selected' : '' }}>Belum Diverifikasi</option>
                        <option value="1" {{ $prestasi->status_verifikasi ? 'selected' : '' }}>Sudah Diverifikasi</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.prestasi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
