@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah User</h1>
    
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
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Level</label>
                    <select name="level" class="form-control" id="level" required>
                        <option value="">Pilih Level</option>
                        <option value="admin">Admin</option>
                        <option value="guru">Guru</option>
                        <option value="kepsek">Kepsek</option>
                        <option value="siswa">Siswa</option>
                        <option value="ortu">Ortu</option>
                        <option value="bk">BK</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="kesiswaan">Kesiswaan</option>
                    </select>
                </div>
                <div class="mb-3" id="guru-field" style="display:none;">
                    <label>Guru <span class="text-danger">*</span></label>
                    <select name="guru_id" class="form-control" id="guru_id">
                        <option value="">Pilih Guru</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" data-has-class="{{ $g->kelas ? 'yes' : 'no' }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" id="siswa-field" style="display:none;">
                    <label>Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-control" id="siswa_id">
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" id="ortu-field" style="display:none;">
                    <label>Orangtua <span class="text-danger">*</span></label>
                    <select name="ortu_id" class="form-control" id="ortu_id">
                        <option value="">Pilih Orangtua</option>
                        @foreach($orangtua as $o)
                            <option value="{{ $o->orangtua_id }}">{{ $o->nama_orangtua }} ({{ $o->hubungan }} - {{ $o->siswa->nama_siswa }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="can_verify" value="1">
                    <label>Can Verify</label>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('level').addEventListener('change', function() {
    const level = this.value;
    const guruField = document.getElementById('guru-field');
    const siswaField = document.getElementById('siswa-field');
    const ortuField = document.getElementById('ortu-field');
    const guruSelect = document.getElementById('guru_id');
    const siswaSelect = document.getElementById('siswa_id');
    const ortuSelect = document.getElementById('ortu_id');
    
    // Reset
    guruField.style.display = 'none';
    siswaField.style.display = 'none';
    ortuField.style.display = 'none';
    guruSelect.required = false;
    siswaSelect.required = false;
    ortuSelect.required = false;
    guruSelect.value = '';
    siswaSelect.value = '';
    ortuSelect.value = '';
    
    // Filter guru options based on level
    const allOptions = guruSelect.querySelectorAll('option');
    allOptions.forEach(option => {
        if (option.value === '') return; // Skip default option
        
        const hasClass = option.getAttribute('data-has-class') === 'yes';
        
        if (level === 'wali_kelas') {
            // Wali kelas: only show guru with class
            option.style.display = hasClass ? 'block' : 'none';
        } else if (['kesiswaan', 'bk', 'guru', 'kepsek'].includes(level)) {
            // Other levels: only show guru without class
            option.style.display = hasClass ? 'none' : 'block';
        }
    });
    
    // Show guru field for: kesiswaan, bk, guru, walas, kepsek
    if (['kesiswaan', 'bk', 'guru', 'wali_kelas', 'kepsek'].includes(level)) {
        guruField.style.display = 'block';
        guruSelect.required = true;
    }
    
    // Show siswa field for: siswa only
    if (level === 'siswa') {
        siswaField.style.display = 'block';
        siswaSelect.required = true;
    }
    
    // Show orangtua field for: ortu only
    if (level === 'ortu') {
        ortuField.style.display = 'block';
        ortuSelect.required = true;
    }
});
</script>
@endsection
