<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PELANGGARAN SISWA</h2>
        <p>Data Pelanggaran Pribadi</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Tanggal</th>
                <th>Guru Pencatat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggarans as $key => $p)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                <td>{{ $p->siswa->kelas->nama ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama ?? '-' }}</td>
                <td>{{ $p->poin }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>{{ $p->guruPencatat->guru->nama_guru ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>
</html>