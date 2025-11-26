<!DOCTYPE html>
<html>
<head>
    <title>Surat Pemberitahuan Sanksi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: bold; }
        .header h2 { margin: 5px 0; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 12px; }
        .surat-info { margin: 30px 0; }
        .content { margin: 20px 0; text-align: justify; }
        .pelanggaran-detail { border: 1px solid #000; padding: 15px; margin: 20px 0; }
        .sanksi-detail { border: 1px solid #000; padding: 15px; margin: 20px 0; }
        .signature { margin-top: 50px; }
        .signature-left { float: left; width: 45%; }
        .signature-right { float: right; width: 45%; text-align: center; }
        .clearfix::after { content: ""; display: table; clear: both; }
        table { border-collapse: collapse; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMK BAKTI NUSANTARA 666</h1>
        <h2>SURAT PEMBERIAN SANKSI</h2>
        <p>Jl. Percobaan, Kec. Cileunyi, Kab. Bandung</p>
        <p>Telp: (021) 1234567 | Email: info@smkn1example.sch.id</p>
    </div>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" class="btn btn-primary">Print Surat</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <div class="surat-info">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 15%;">Nomor</td>
                <td style="border: none; width: 2%;">:</td>
                <td style="border: none;">{{ str_pad($pelanggaran->id, 3, '0', STR_PAD_LEFT) }}/SANKSI/{{ date('Y') }}</td>
            </tr>
            <tr>
                <td style="border: none;">Hal</td>
                <td style="border: none;">:</td>
                <td style="border: none;"><strong>Pemberian Sanksi Pelanggaran</strong></td>
            </tr>
            <tr>
                <td style="border: none;">Tanggal</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ date('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p>Kepada Yth.<br>
        <strong>Orang Tua/Wali Siswa {{ $pelanggaran->siswa->nama ?? '-' }}</strong><br>
        Kelas {{ $pelanggaran->siswa->kelas->nama ?? '-' }}<br>
        Di tempat</p>

        <p>Dengan hormat,</p>

        <p>Melalui surat ini kami sampaikan bahwa putra/putri Bapak/Ibu telah melakukan pelanggaran tata tertib sekolah dan telah diberikan sanksi dengan rincian sebagai berikut:</p>

        <div class="pelanggaran-detail">
            <h4 style="margin-top: 0; text-align: center;">DETAIL PELANGGARAN</h4>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%; padding: 5px;">Nama Siswa</td>
                    <td style="width: 2%; padding: 5px;">:</td>
                    <td style="padding: 5px;"><strong>{{ $pelanggaran->siswa->nama ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Kelas</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">{{ $pelanggaran->siswa->kelas->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Jenis Pelanggaran</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Poin Pelanggaran</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;"><strong>{{ $pelanggaran->poin }} poin</strong></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Tanggal Kejadian</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">{{ $pelanggaran->created_at->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Guru Pencatat</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">{{ $pelanggaran->guruPencatat->guru->nama_guru ?? '-' }}</td>
                </tr>
                @if($pelanggaran->keterangan)
                <tr>
                    <td style="padding: 5px; vertical-align: top;">Keterangan</td>
                    <td style="padding: 5px; vertical-align: top;">:</td>
                    <td style="padding: 5px;">{{ $pelanggaran->keterangan }}</td>
                </tr>
                @endif
            </table>
        </div>

        @if($pelanggaran->sanksi->count() > 0)
        <div class="sanksi-detail">
            <h4 style="margin-top: 0; text-align: center;">SANKSI YANG DIBERIKAN</h4>
            @foreach($pelanggaran->sanksi as $sanksi)
            <table style="width: 100%; margin-bottom: 10px;">
                <tr>
                    <td style="width: 25%; padding: 5px;">Jenis Sanksi</td>
                    <td style="width: 2%; padding: 5px;">:</td>
                    <td style="padding: 5px;"><strong>{{ $sanksi->jenisSanksi->nama_sanksi ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Tanggal Mulai</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">{{ $sanksi->tanggal_mulai ? \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 5px;">Tanggal Selesai</td>
                    <td style="padding: 5px;">:</td>
                    <td style="padding: 5px;">{{ $sanksi->tanggal_selesai ? \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d F Y') : '-' }}</td>
                </tr>
                @if($sanksi->catatan)
                <tr>
                    <td style="padding: 5px; vertical-align: top;">Catatan</td>
                    <td style="padding: 5px; vertical-align: top;">:</td>
                    <td style="padding: 5px;">{{ $sanksi->catatan }}</td>
                </tr>
                @endif
            </table>
            @endforeach
        </div>
        @endif

        <p>Sehubungan dengan hal tersebut, kami mohon kepada Bapak/Ibu untuk:</p>
        <ol>
            <li>Memberikan bimbingan dan pengawasan yang lebih intensif kepada putra/putri Bapak/Ibu</li>
            <li>Bekerja sama dengan pihak sekolah dalam mendidik dan membimbing siswa</li>
            <li>Memastikan putra/putri Bapak/Ibu melaksanakan sanksi yang telah ditetapkan</li>
            <li>Menandatangani surat pemberitahuan ini sebagai bukti telah menerima informasi</li>
        </ol>

        <p>Demikian surat pemberitahuan ini kami sampaikan. Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.</p>
    </div>

    <div class="signature clearfix">
        <div class="signature-left">
            <p>Mengetahui,<br>
            Orang Tua/Wali Siswa</p>
            <br><br><br>
            <p>_________________________<br>
            Nama: .............................<br>
            Tanggal: .........................</p>
        </div>
        
        <div class="signature-right">
            <p>{{ date('d F Y') }}<br>
            Kepala Sekolah</p>
            <br><br><br>
            <p>_________________________<br>
            <strong>{{ $kepsek->guru->nama_guru ?? 'Kepala Sekolah' }}</strong><br>
            @if($kepsek && $kepsek->guru && $kepsek->guru->nip)
            NIP. {{ $kepsek->guru->nip }}
            @endif
            </p>
        </div>
    </div>
</body>
</html>