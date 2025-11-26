@extends('admin.layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Kepala Sekolah</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Stats Cards -->
    <div class="row mb-4">
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
                    <a class="small text-white stretched-link" href="/kepsek/export">Export Laporan</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Prestasi</h6>
                            <h2 class="mb-0 mt-2">{{ $prestasiBulanIni }}</h2>
                            <small>Bulan Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-trophy fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="/kepsek/export">Export Laporan</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Belum Ada Catatan</h6>
                            <h2 class="mb-0 mt-2">{{ $monitoringBelumCatatan ?? 0 }}</h2>
                            <small>Data Saat Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('kepsek.monitoring.index') }}">Monitoring Data</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #6f42c1, #5a32a3);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Sudah Ada Catatan</h6>
                            <h2 class="mb-0 mt-2">{{ $monitoringSudahCatatan ?? 0 }}</h2>
                            <small>Data Saat Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('kepsek.monitoring.index') }}">Monitoring Data</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Trend Pelanggaran vs Prestasi (6 Bulan Terakhir)
                </div>
                <div class="card-body">
                    <canvas id="lineChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <div class="col-xl-6">
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
                                    <th>Kelas</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPelanggaran as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $p->total }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-trophy me-1"></i>
                    Top 5 Siswa dengan Prestasi Terbanyak
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topPrestasi as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td><span class="badge bg-success">{{ $p->total }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
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
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Pelanggaran',
                data: @json($chartData['pelanggaran']),
                borderColor: '#FF8040',
                backgroundColor: 'rgba(255, 128, 64, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Prestasi',
                data: @json($chartData['prestasi']),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection
