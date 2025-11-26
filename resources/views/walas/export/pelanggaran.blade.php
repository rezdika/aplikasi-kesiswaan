<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header h2 { margin: 5px 0; font-size: 18px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .badge-danger { background-color: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PELANGGARAN SISWA</h1>
        <h2>SMK NEGERI 1 EXAMPLE</h2>
        <p>Periode: {{ request('tanggal_mulai') ? date('d/m/Y', strtotime(request('tanggal_mulai'))) : 'Semua' }} - {{ request('tanggal_selesai') ? date('d/m/Y', strtotime(request('tanggal_selesai'))) : 'Semua' }}</p>
    </div>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Print Laporan</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th width="25%">Jenis Pelanggaran</th>
                <th width="8%">Poin</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Guru Pencatat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggarans as $key => $p)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                <td class="text-center">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge-danger">{{ $p->poin }}</span>
                </td>
                <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                <td>{{ $p->guruPencatat->guru->nama_guru ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px;">
        <p><strong>Total Pelanggaran:</strong> {{ $pelanggarans->count() }} kasus</p>
        <p><strong>Total Poin:</strong> {{ $pelanggarans->sum('poin') }} poin</p>
    </div>

    <div style="margin-top: 50px; float: right;">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <br><br><br>
        <p>_________________________</p>
        <p>Kepala Sekolah</p>
    </div>
</body>
</html>