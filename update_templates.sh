#!/bin/bash

# Script untuk mengupdate semua template export dengan data kepsek

# Array direktori yang perlu diupdate
directories=("bk" "kesiswaan" "kepsek" "ortu" "siswa" "walas")

# Update template pelanggaran dan prestasi (laporan)
for dir in "${directories[@]}"; do
    # Update pelanggaran.blade.php
    if [ -f "resources/views/$dir/export/pelanggaran.blade.php" ]; then
        sed -i '' 's/<p>Kepala Sekolah<\/p>/<p>{{ $kepsek->nama_guru ?? '\''Kepala Sekolah'\'' }}<\/p>\n        @if($kepsek \&\& $kepsek->nip)\n        <p>NIP. {{ $kepsek->nip }}<\/p>\n        @endif/g' "resources/views/$dir/export/pelanggaran.blade.php"
        echo "Updated $dir/export/pelanggaran.blade.php"
    fi
    
    # Update prestasi.blade.php
    if [ -f "resources/views/$dir/export/prestasi.blade.php" ]; then
        sed -i '' 's/<p>Kepala Sekolah<\/p>/<p>{{ $kepsek->nama_guru ?? '\''Kepala Sekolah'\'' }}<\/p>\n        @if($kepsek \&\& $kepsek->nip)\n        <p>NIP. {{ $kepsek->nip }}<\/p>\n        @endif/g' "resources/views/$dir/export/prestasi.blade.php"
        echo "Updated $dir/export/prestasi.blade.php"
    fi
done

echo "Template update completed!"