INSERT INTO `jenis_pelanggaran` (`nama_pelanggaran`, `poin`, `kategori`, `sanksi_id`) VALUES
-- A. PELANGGARAN TERHADAP BARANG
('Mengotori (mencorat-coret) barang milik sekolah, guru, karyawan atau teman', 10, 'Ringan', 2),
('Merusak atau menghilangkan barang milik sekolah, guru, karyawan atau teman', 25, 'Sedang', 5),
('Mengambil (mencuri) barang milik sekolah, guru, karyawan atau teman', 50, 'Berat', 9),
('Makan dan minum di dalam kelas saat berlangsungnya pelajaran', 5, 'Ringan', 1),
('Mengaktifkan alat komunikasi didalam kelas pada saat pelajaran berlangsung', 5, 'Ringan', 1),
('Membuang sampah tidak pada tempatnya', 5, 'Ringan', 1),
('Membawa teman selain siswa SMK BN maupun dengan siswa sekolah lain atau pihak lain', 5, 'Ringan', 1),
('Membawa benda yang tidak ada kaitannya dengan proses belajar mengajar', 10, 'Ringan', 2),
('Bertengkar / bertentangan dengan teman di lingkungan sekolah', 15, 'Sedang', 3),
('Memalsu tandatangan guru, walikelas, kepala sekolah', 40, 'Berat', 8),
('Menggunakan/menggelapkan SPP dari orang tua', 40, 'Berat', 8),
('Membentuk organisasi selain OSIS maupun kegiatan lainnya tanpa seijin Kepala Sekolah', 15, 'Sedang', 3),
('Menyalahgunakan Uang SPP', 40, 'Berat', 8),
('Berbuat asusila', 100, 'Berat', 9),

-- B. ROKOK
('Membawa rokok', 25, 'Sedang', 5),
('Merokok / menghisap rokok di sekolah', 40, 'Berat', 8),
('Merokok/ menghisap rokok di luar sekolah memakai seragam sekolah', 40, 'Berat', 8),

-- C. BUKU, MAJALAH ATAU KASET TERLARANG
('Membawa buku, majalah, kaset terlarang atau HP berisi gambar dan film porno', 25, 'Sedang', 5),
('Memperjual belikan buku, majalah atau kaset terlarang', 75, 'Berat', 9),

-- D. SENJATA
('Membawa senjata tajam tanpa ijin', 40, 'Berat', 8),
('Memperjual belikan senjata tajam di sekolah', 40, 'Berat', 8),
('Menggunakan senjata tajam untuk mengancam', 75, 'Berat', 9),
('Menggunakan senjata tajam untuk melukai', 75, 'Berat', 9),

-- E. OBAT / MINUMAN TERLARANG
('Membawa obat terlarang / minuman terlarang', 75, 'Berat', 9),
('Menggunakan obat / minuman terlarang di dalam lingkungan sekolah', 100, 'Berat', 9),
('Memperjual belikan obat / minuman terlarang di dalam / di luar sekolah', 100, 'Berat', 9),

-- F. PERKELAHIAN
('Disebabkan oleh siswa di dalam sekolah (intern)', 75, 'Berat', 9),
('Disebabkan oleh sekolah lain', 25, 'Sedang', 5),
('Antar siswa SMK BN 666', 75, 'Berat', 9),

-- G. PELANGGARAN TERHADAP KEPALA SEKOLAH, GURU DAN KARYAWAN
('Disertai ancaman', 75, 'Berat', 9),
('Disertai pemukulan', 100, 'Berat', 9),

-- II. KERAJINAN
-- A. KETERLAMBATAN
('Terlambat masuk sekolah lebih dari 15 menit - Satu kali', 2, 'Ringan', 1),
('Terlambat masuk sekolah lebih dari 15 menit - Dua kali', 3, 'Ringan', 1),
('Terlambat masuk sekolah lebih dari 15 menit - Tiga kali dan selebihnya', 5, 'Ringan', 1),
('Terlambat masuk karena izin', 3, 'Ringan', 1),
('Terlambat masuk karena diberi tugas guru', 2, 'Ringan', 1),
('Terlambat masuk karena alasan yang dibuat-buat', 5, 'Ringan', 1),
('Izin keluar saat proses belajar berlangsung dan tidak kembali', 10, 'Ringan', 2),
('Pulang tanpa izin', 10, 'Ringan', 2),
('Sakit tanpa keterangan (surat)', 2, 'Ringan', 1),
('Izin tanpa keterangan (surat)', 2, 'Ringan', 1),
('Alpa', 5, 'Ringan', 1),
('Tidak mengikuti kegiatan belajar (membolos)', 10, 'Ringan', 2),
('Siswa tidak masuk dengan membuat keterangan (surat) Palsu', 10, 'Ringan', 2),
('Siswa keluar kelas saat proses belajar mengajar berlangsung tanpa izin', 5, 'Ringan', 1),

-- III. KERAPIAN
-- A. PAKAIAN
('Memakai seragam tidak rapi / tidak dimasukkan', 5, 'Ringan', 1),
('Siswa putri memakai seragam yang ketat / rok pendek', 5, 'Ringan', 1),
('Tidak memakai perlengkapan upacara bendera (topi)', 5, 'Ringan', 1),
('Salah memakai baju, rok atau celana', 5, 'Ringan', 1),
('Salah atau tidak memakai ikat pinggang', 5, 'Ringan', 1),
('Salah memakai sepatu (tidak sesuai ketentuan)', 5, 'Ringan', 1),
('Tidak memakai kaos kaki', 5, 'Ringan', 1),
('Salah / tidak memakai kaos dalam', 5, 'Ringan', 1),
('Memakai topi yang bukan topi sekolah di lingkungan sekolah', 5, 'Ringan', 1),
('Siswa putri memakai perhiasan perlebihan', 5, 'Ringan', 1),
('Siswa putra memakai perhiasan atau aksesories (kalung, gelang, dll)', 5, 'Ringan', 1),

-- B. RAMBUT
('Potongan rambut putra tidak sesuai dengan ketentuan sekolah', 15, 'Sedang', 3),
('Dicat / diwarna-warnai (putra-putri)', 15, 'Sedang', 3),

-- C. BADAN
('Bertato', 100, 'Berat', 9),
('Kuku di cat', 20, 'Sedang', 4);
