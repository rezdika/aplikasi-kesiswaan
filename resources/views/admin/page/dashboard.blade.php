@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Sistem Kesiswaan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Stats Cards - ADMIN -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #001BB7, #0046FF);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Siswa</h6>
                            <h2 class="mb-0 mt-2">{{ $totalSiswa }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('admin.siswa.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Guru</h6>
                            <h2 class="mb-0 mt-2">{{ $totalGuru }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('admin.guru.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #FF8040, #ff6020);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Kelas</h6>
                            <h2 class="mb-0 mt-2">{{ $totalKelas }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-school fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('admin.kelas.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #6f42c1, #5a32a3);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Orang Tua</h6>
                            <h2 class="mb-0 mt-2">{{ $totalOrtu }}</h2>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('admin.orangtua.index') }}">Lihat Detail</a>
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
                    Grafik Pelanggaran vs Prestasi (6 Bulan Terakhir)
                </div>
                <div class="card-body">
                    <canvas id="lineChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Top 5 Jenis Pelanggaran
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($topPelanggaran as $index => $tp)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary rounded-circle me-2">{{ $index + 1 }}</span>
                                <strong>{{ $tp->jenisPelanggaran->nama ?? 'Unknown' }}</strong>
                            </div>
                            <span class="badge bg-danger rounded-pill">{{ $tp->total }}</span>
                        </div>
                        @empty
                        <div class="list-group-item text-center text-muted">
                            Belum ada data pelanggaran
                        </div>
                        @endforelse
                    </div>
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
                    Pelanggaran Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-danger">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggaranTerbaru as $p)
                                <tr>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td><span class="badge bg-warning">{{ Str::limit($p->jenisPelanggaran->nama ?? '-', 20) }}</span></td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('admin.pelanggaran') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-trophy me-1"></i>
                    Prestasi Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prestasiTerbaru as $pr)
                                <tr>
                                    <td>{{ $pr->siswa->nama_siswa ?? '-' }}</td>
                                    <td><span class="badge bg-success">{{ Str::limit($pr->jenisPrestasi->nama ?? '-', 20) }}</span></td>
                                    <td>{{ $pr->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('admin.prestasi') }}" class="btn btn-sm btn-success">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('lineChart').getContext('2d');
const lineChart = new Chart(ctx, {
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
            legend: {
                position: 'top',
            },
            title: {
                display: false
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
</script>
@endsection
