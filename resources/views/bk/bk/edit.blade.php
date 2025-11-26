@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Bimbingan Konseling</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('bk.bk.update', $bk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Pelanggaran</label>
                    <select name="pelanggaran_id" class="form-control" required onchange="setSiswa(this)">
                        @foreach($pelanggarans as $p)
                            <option value="{{ $p->id }}" data-siswa="{{ $p->siswa_id }}" {{ $bk->pelanggaran_id == $p->id ? 'selected' : '' }}>
                                {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="siswa_id" id="siswa_id" value="{{ $bk->siswa_id }}">
                <div class="mb-3">
                    <label>Tindakan</label>
                    <textarea name="tindakan" class="form-control" required placeholder="Masukkan tindakan bimbingan konseling">{{ $bk->tindakan }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">Pilih Status</option>
                        <option value="terdaftar" {{ $bk->status == 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                        <option value="diproses" {{ $bk->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $bk->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tindak_lanjut" {{ $bk->status == 'tindak_lanjut' ? 'selected' : '' }}>Tindak Lanjut</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('bk.bk.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
function setSiswa(select) {
    const selectedOption = select.options[select.selectedIndex];
    const siswaId = selectedOption.getAttribute('data-siswa');
    document.getElementById('siswa_id').value = siswaId || '';
}
</script>
@endsection

