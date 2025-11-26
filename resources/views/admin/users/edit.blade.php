@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit User</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                </div>
                <div class="mb-3">
                    <label>Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Level</label>
                    <select name="level" class="form-control" id="level" required>
                        <option value="admin" {{ $user->level == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ $user->level == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="kepsek" {{ $user->level == 'kepsek' ? 'selected' : '' }}>Kepsek</option>
                        <option value="siswa" {{ $user->level == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="ortu" {{ $user->level == 'ortu' ? 'selected' : '' }}>Ortu</option>
                        <option value="bk" {{ $user->level == 'bk' ? 'selected' : '' }}>BK</option>
                        <option value="wali_kelas" {{ $user->level == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        <option value="kesiswaan" {{ $user->level == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                    </select>
                </div>
                <div class="mb-3" id="guru-field" style="display:none;">
                    <label>Guru <span class="text-danger">*</span></label>
                    <select name="guru_id" class="form-control" id="guru_id">
                        <option value="">Pilih Guru</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" data-has-class="{{ $g->kelas ? 'yes' : 'no' }}" {{ $user->guru_id == $g->id ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" id="siswa-field" style="display:none;">
                    <label>Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-control" id="siswa_id">
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}" {{ $user->siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama_siswa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" id="ortu-field" style="display:none;">
                    <label>Orangtua <span class="text-danger">*</span></label>
                    <select name="ortu_id" class="form-control" id="ortu_id">
                        <option value="">Pilih Orangtua</option>
                        @foreach($orangtua as $o)
                            <option value="{{ $o->orangtua_id }}" {{ $user->ortu_id == $o->orangtua_id ? 'selected' : '' }}>{{ $o->nama_orangtua }} ({{ $o->hubungan }} - {{ $o->siswa->nama_siswa }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="can_verify" value="1" {{ $user->can_verify ? 'checked' : '' }}>
                    <label>Can Verify</label>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
function updateFields() {
    const level = document.getElementById('level').value;
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
}

document.getElementById('level').addEventListener('change', updateFields);

// Trigger on page load
document.addEventListener('DOMContentLoaded', updateFields);
</script>
@endsection

