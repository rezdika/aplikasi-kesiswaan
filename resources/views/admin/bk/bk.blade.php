@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">View Data Bimbingan Konseling</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Pelanggaran</th>
                        <th>Tindakan</th>
                        <th>Status</th>
                        <th>Konselor</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bks as $key => $b)
                    <tr>
                        <td>{{ $bks->firstItem() + $key }}</td>
                        <td>{{ $b->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $b->pelanggaran->jenisPelanggaran->nama ?? '-' }}</td>
                        <td>{{ $b->tindakan }}</td>
                        <td>
                            <span class="badge bg-{{ $b->status == 'selesai' ? 'success' : ($b->status == 'diproses' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td>{{ $b->bk->guru->nama_guru ?? '-' }}</td>
                        <td>{{ $b->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data bimbingan konseling</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $bks->links() }}
        </div>
    </div>
</div>
@endsection