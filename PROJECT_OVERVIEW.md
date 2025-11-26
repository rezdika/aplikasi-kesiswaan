# Sistem Informasi Kesiswaan SMK Bakti Nusantara 666

## Deskripsi Project
Web aplikasi untuk mengelola data kesiswaan yang mencakup catatan prestasi dan pelanggaran siswa di SMK Bakti Nusantara 666. Sistem ini membantu pihak sekolah dalam memantau dan mengelola perilaku siswa secara digital.

## Teknologi yang Digunakan
- **Framework**: Laravel (PHP)
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Database**: MySQL
- **Template**: TemplateMo DigiMedia v3
- **Library**: jQuery, Owl Carousel, WOW.js (animasi)

## Fitur Utama

### 1. Dashboard Statistik
- Total jumlah siswa
- Persentase siswa berprestasi
- Persentase siswa tanpa pelanggaran
- Grafik lingkaran (progress circle) untuk visualisasi data

### 2. Manajemen Data Kesiswaan
- **Jenis Pelanggaran**: Daftar kategori pelanggaran dengan sistem poin
- **Data Kelas**: Informasi kelas dan jurusan yang tersedia
- **Bimbingan Konseling**: Catatan sesi konseling siswa

### 3. Statistik Pelanggaran
- Data pelanggaran per semester
- Visualisasi dalam bentuk carousel cards
- Filter berdasarkan tahun ajaran

### 4. Interface Modern
- Responsive design untuk semua perangkat
- Animasi smooth dengan WOW.js
- Carousel interaktif untuk menampilkan data

## Struktur Database (Estimasi)
```
- siswa (id, nama_siswa, kelas_id, ...)
- kelas (id, nama_kelas, jurusan, ...)
- jenis_pelanggaran (id, nama_pelanggaran, kategori, poin, ...)
- pelanggaran (id, siswa_id, jenis_pelanggaran_id, tanggal, ...)
- prestasi (id, siswa_id, jenis_prestasi, tanggal, ...)
- bimbingan_konseling (id, siswa_id, tanggal, status, ...)
```

## Alur Kerja Sistem

### 1. Input Data
- Admin memasukkan data siswa dan kelas
- Mencatat jenis-jenis pelanggaran dengan poin masing-masing
- Input pelanggaran siswa ketika terjadi
- Catat prestasi siswa
- Jadwalkan bimbingan konseling

### 2. Pemrosesan Data
- Sistem menghitung statistik otomatis
- Mengelompokkan data per semester
- Menghitung persentase siswa berprestasi dan bermasalah

### 3. Tampilan Dashboard
- Menampilkan ringkasan statistik di halaman utama
- Visualisasi data dalam bentuk grafik dan tabel
- Filter dan pencarian data

## Keunggulan Sistem
- **User-Friendly**: Interface yang mudah dipahami
- **Responsive**: Dapat diakses dari berbagai perangkat
- **Real-time**: Data statistik terupdate otomatis
- **Comprehensive**: Mencakup semua aspek kesiswaan
- **Visual**: Grafik dan chart yang informatif

## Target Pengguna
- **Guru BK**: Mengelola bimbingan konseling
- **Wali Kelas**: Memantau siswa di kelasnya
- **Kepala Sekolah**: Melihat overview statistik sekolah
- **Staff Kesiswaan**: Input dan manage data siswa

## Manfaat Implementasi
1. **Digitalisasi**: Mengganti sistem manual menjadi digital
2. **Efisiensi**: Mempercepat proses pencatatan dan pelaporan
3. **Akurasi**: Mengurangi kesalahan human error
4. **Monitoring**: Memudahkan pemantauan perkembangan siswa
5. **Reporting**: Generate laporan otomatis

## Pengembangan Selanjutnya
- Sistem notifikasi untuk orang tua
- Mobile app untuk akses yang lebih mudah
- Integration dengan sistem akademik
- Export data ke format Excel/PDF
- Dashboard analytics yang lebih advanced

---
*Project ini dikembangkan untuk meningkatkan efektivitas pengelolaan data kesiswaan di SMK Bakti Nusantara 666*