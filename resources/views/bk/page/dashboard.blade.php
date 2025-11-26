@extends('admin.layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard BK (Bimbingan Konseling)</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Siswa</h6>
                            <h2 class="mb-0 mt-2">{{ $totalSiswa }}</h2>
                            <small>Siswa Aktif</small>
                        </div>
                        <div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
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
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Bimbingan</h6>
                            <h2 class="mb-0 mt-2">{{ $totalBimbingan }}</h2>
                            <small>Semua Waktu</small>
                        </div>
                        <div>
                            <i class="fas fa-user-friends fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('bk.bk.index') }}">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Bimbingan</h6>
                            <h2 class="mb-0 mt-2">{{ $bimbinganBulanIni }}</h2>
                            <small>Bulan Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between" style="background: rgba(0,0,0,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('bk.bk.index') }}">Lihat Detail</a>
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
                    Trend Pelanggaran vs Bimbingan (6 Bulan Terakhir)
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
                    Top 5 Siswa Perlu Bimbingan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-danger">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Total Pelanggaran</th>
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
                    <i class="fas fa-user-friends me-1"></i>
                    Bimbingan Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Kasus</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bimbinganTerbaru as $b)
                                <tr>
                                    <td>{{ $b->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $b->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ Str::limit($b->kasus ?? '-', 20) }}</td>
                                    <td>{{ $b->created_at->format('d/m/Y') }}</td>
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
                label: 'Bimbingan',
                data: @json($chartData['bimbingan']),
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
});
</script>
@endsection
