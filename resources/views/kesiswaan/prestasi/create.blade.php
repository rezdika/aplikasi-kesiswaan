@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Prestasi</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('kesiswaan.prestasi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Siswa</label>
                    <select name="siswa_id" class="form-control" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }} : {{ $s->kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Jenis Prestasi</label>
                    <select name="jenis_prestasi_id" id="jenis_prestasi_id" class="form-control" required>
                        <option value="">Pilih Jenis</option>
                        @foreach($jenisPrestasis as $jp)
                            <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">{{ $jp->nama_prestasi }} ({{ $jp->poin }} poin)</option>
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
                    <input type="number" name="poin" id="poin" class="form-control" readonly required>
                </div>
                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" {{ !$tahunAjaranAktif ? 'disabled' : '' }}>Simpan</button>
                <a href="{{ route('kesiswaan.prestasi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('jenis_prestasi_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const poin = selectedOption.getAttribute('data-poin');
    document.getElementById('poin').value = poin || '';
});
</script>
@endsection
