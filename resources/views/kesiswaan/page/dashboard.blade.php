@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Kesiswaan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Alert Notification -->
    @if($menungguVerifikasi > 5)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Perhatian!</strong> Ada {{ $menungguVerifikasi }} data menunggu verifikasi.
        <a href="{{ route('kesiswaan.verifikasi.index') }}" class="alert-link">Verifikasi Sekarang</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @elseif($menungguVerifikasi > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        Ada {{ $menungguVerifikasi }} data menunggu verifikasi.
        <a href="{{ route('kesiswaan.verifikasi.index') }}" class="alert-link">Lihat Detail</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @else
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        Semua data sudah terverifikasi!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-4 mb-3">
            <a href="{{ route('kesiswaan.pelanggaran.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #FF8040, #ff6020);">
                    <div class="card-body text-white text-center">
                        <i class="fas fa-plus-circle fa-3x mb-2"></i>
                        <h5 class="mb-0">Input Pelanggaran</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 mb-3">
            <a href="{{ route('kesiswaan.prestasi.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <div class="card-body text-white text-center">
                        <i class="fas fa-plus-circle fa-3x mb-2"></i>
                        <h5 class="mb-0">Input Prestasi</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-4 mb-3">
            <a href="{{ route('kesiswaan.verifikasi.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #0046FF, #001BB7);">
                    <div class="card-body text-white text-center">
                        <i class="fas fa-check-circle fa-3x mb-2"></i>
                        <h5 class="mb-0">Verifikasi Data</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

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
                    <a class="small text-white stretched-link" href="{{ route('kesiswaan.pelanggaran.index') }}">Lihat Detail</a>
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
                    <a class="small text-white stretched-link" href="{{ route('kesiswaan.prestasi.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Menunggu Verifikasi</h6>
                            <h2 class="mb-0 mt-2">{{ $menungguVerifikasi }}</h2>
                            <small>Data Pending</small>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('kesiswaan.verifikasi.index') }}">Verifikasi</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #0046FF, #001BB7);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Sanksi Selesai</h6>
                            <h2 class="mb-0 mt-2">{{ $sanksiSelesai }}</h2>
                            <small>Bulan Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('kesiswaan.sanksi.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-xl-7">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Trend Pelanggaran vs Prestasi (6 Bulan Terakhir)
                </div>
                <div class="card-body">
                    <canvas id="lineChart" width="100%" height="50"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Status Verifikasi Data
                </div>
                <div class="card-body text-center" style="min-height: 300px;">
                    <canvas id="donutChart" style="max-height: 250px;"></canvas>
                    <div class="mt-3">
                        <span class="badge bg-success me-2">✅ Terverifikasi: {{ $donutData['terverifikasi'] }}</span>
                        <span class="badge bg-warning">⏳ Pending: {{ $donutData['belum'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-clock me-1"></i>
                    Data Menunggu Verifikasi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th>Jenis</th>
                                    <th>Siswa</th>
                                    <th>Detail</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataVerifikasi as $d)
                                <tr>
                                    <td>
                                        @if($d['jenis'] == 'Pelanggaran')
                                            <span class="badge bg-danger">Pelanggaran</span>
                                        @else
                                            <span class="badge bg-success">Prestasi</span>
                                        @endif
                                    </td>
                                    <td>{{ $d['siswa'] }}</td>
                                    <td>{{ Str::limit($d['detail'], 20) }}</td>
                                    <td>{{ $d['tanggal'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data pending</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('kesiswaan.verifikasi.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-check-circle me-1"></i> Verifikasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-check-circle me-1"></i>
                    Pelaksanaan Sanksi Selesai
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Jenis Sanksi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sanksiTerbaru as $s)
                                <tr>
                                    <td>{{ $s->sanksi?->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                                    <td>{{ Str::limit($s->sanksi->jenis_sanksi ?? '-', 15) }}</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td>{{ $s->updated_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada sanksi selesai</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('kesiswaan.sanksi.index') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-list me-1"></i> Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Line Chart
const ctxLine = document.getElementById('lineChart').getContext('2d');
new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [
            {
                label: 'Pelanggaran',
                data: {!! json_encode($chartData['pelanggaran']) !!},
                borderColor: '#FF8040',
                backgroundColor: 'rgba(255, 128, 64, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Prestasi',
                data: {!! json_encode($chartData['prestasi']) !!},
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// Donut Chart
const ctxDonut = document.getElementById('donutChart').getContext('2d');
new Chart(ctxDonut, {
    type: 'doughnut',
    data: {
        labels: ['Terverifikasi', 'Belum Diverifikasi'],
        datasets: [{
            data: [{{ $donutData['terverifikasi'] }}, {{ $donutData['belum'] }}],
            backgroundColor: ['#28a745', '#ffc107'],
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
</script>
@endsection
