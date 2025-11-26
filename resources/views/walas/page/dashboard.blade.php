@extends('admin.layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Wali Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-4 mb-3">
            <a href="{{ route('walas.siswa.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <div class="card-body text-white text-center">
                        <i class="fas fa-users fa-3x mb-2"></i>
                        <h5 class="mb-0">Data Siswa Kelas</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 mb-3">
            <a href="{{ route('walas.pelanggaran.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #FF8040, #ff6020);">
                    <div class="card-body text-white text-center">
                        <i class="fas fa-plus-circle fa-3x mb-2"></i>
                        <h5 class="mb-0">Input Pelanggaran</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 mb-3">
            <a href="{{ route('walas.pelanggaran.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <div class="card-body text-white text-center">
                        <i class="fas fa-list fa-3x mb-2"></i>
                        <h5 class="mb-0">Monitoring Kelas</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Siswa Kelas Saya</h6>
                            <h2 class="mb-0 mt-2">{{ $totalSiswa }}</h2>
                            <small>Siswa Aktif</small>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('walas.siswa.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #FF8040, #ff6020);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Pelanggaran</h6>
                            <h2 class="mb-0 mt-2">{{ $pelanggaranBulanIni }}</h2>
                            <small>Bulan Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('walas.pelanggaran.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Terverifikasi</h6>
                            <h2 class="mb-0 mt-2">{{ $pelanggaranTerverifikasi }}</h2>
                            <small>Data Valid</small>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Pelanggaran</h6>
                            <h2 class="mb-0 mt-2">{{ $totalPelanggaran }}</h2>
                            <small>Semua Waktu</small>
                        </div>
                        <div>
                            <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('walas.pelanggaran.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart & Table Row -->
    <div class="row mb-4">
        <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Data Pelanggaran vs Prestasi Kelas
                </div>
                <div class="card-body text-center" style="min-height: 300px;">
                    <canvas id="pieChart" style="max-height: 250px;"></canvas>
                    <div class="mt-3">
                        <span class="badge bg-danger me-2">⚠️ Pelanggaran: {{ $totalPelanggaran }}</span>
                        <span class="badge bg-success">🏆 Prestasi: {{ $totalPrestasi }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Top 5 Siswa dengan Pelanggaran Terbanyak
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPelanggaran as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $p->total }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-clock me-1"></i>
                    Pelanggaran Terbaru Kelas Saya
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-warning">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Pencatat</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggaranTerbaru as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
                                    <td>{{ $p->guru->guru->nama_guru ?? '-' }}</td>
                                    <td>
                                        @if($p->verifikasi && $p->verifikasi->status == 'diverifikasi')
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @elseif($p->verifikasi && $p->verifikasi->status == 'direvisi')
                                            <span class="badge bg-info">Direvisi</span>
                                        @elseif($p->verifikasi && $p->verifikasi->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-warning">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pelanggaran', 'Prestasi'],
            datasets: [{
                data: [{{ $totalPelanggaran }}, {{ $totalPrestasi }}],
                backgroundColor: ['#dc3545', '#28a745'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
@endsection
