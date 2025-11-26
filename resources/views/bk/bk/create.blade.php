@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Bimbingan Konseling</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Bimbingan Konseling
        </div>
        <div class="card-body">
            <form action="{{ route('bk.bk.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Pelanggaran Terpilih</label>
                    @if($selectedPelanggaran)
                        <input type="text" class="form-control" value="{{ $selectedPelanggaran->siswa->nama_siswa }} ({{ $selectedPelanggaran->siswa->kelas->nama_kelas ?? '-' }}) - {{ $selectedPelanggaran->jenisPelanggaran->nama }}" readonly>
                        <input type="hidden" name="pelanggaran_id" value="{{ $selectedPelanggaran->id }}">
                        <input type="hidden" name="siswa_id" value="{{ $selectedPelanggaran->siswa_id }}">
                    @else
                        <input type="text" class="form-control" value="Tidak ada pelanggaran dipilih" readonly>
                        <div class="text-danger mt-1">Silakan pilih pelanggaran dari halaman index terlebih dahulu</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Tindakan</label>
                    <textarea name="tindakan" class="form-control" required placeholder="Masukkan tindakan bimbingan konseling"></textarea>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="terdaftar" selected>Terdaftar</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="tindak_lanjut">Tindak Lanjut</option>
                    </select>
                </div>
                @if($selectedPelanggaran)
                    <button type="submit" class="btn btn-primary">Simpan</button>
                @else
                    <button type="button" class="btn btn-primary" disabled>Simpan</button>
                @endif
                <a href="{{ route('bk.bk.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>


@endsection

