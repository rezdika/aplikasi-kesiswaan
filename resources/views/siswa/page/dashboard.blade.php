@extends('admin.layouts.app')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Siswa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    @if($sanksiAktif > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Perhatian!</strong> Anda memiliki {{ $sanksiAktif }} sanksi yang sedang berjalan.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #FF8040, #ff6020);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Pelanggaran</h6>
                            <h2 class="mb-0 mt-2">{{ $totalPelanggaran }}</h2>
                            <small>Semua Waktu</small>
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
                            <h6 class="mb-0">Total Prestasi</h6>
                            <h2 class="mb-0 mt-2">{{ $totalPrestasi }}</h2>
                            <small>Semua Waktu</small>
                        </div>
                        <div>
                            <i class="fas fa-trophy fa-3x opacity-50"></i>
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
                            <h6 class="mb-0">Pelanggaran</h6>
                            <h2 class="mb-0 mt-2">{{ $pelanggaranBulanIni }}</h2>
                            <small>Bulan Ini</small>
                        </div>
                        <div>
                            <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card text-white mb-4" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Sanksi Aktif</h6>
                            <h2 class="mb-0 mt-2">{{ $sanksiAktif }}</h2>
                            <small>Sedang Berjalan</small>
                        </div>
                        <div>
                            <i class="fas fa-exclamation-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
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
                    Perbandingan Pelanggaran vs Prestasi
                </div>
                <div class="card-body text-center" style="min-height: 300px;">
                    <canvas id="pieChart" style="max-height: 250px;"></canvas>
                    <div class="mt-3">
                        <span class="badge bg-danger me-2">Pelanggaran: {{ $totalPelanggaran }}</span>
                        <span class="badge bg-success">Prestasi: {{ $totalPrestasi }}</span>
                    </div>
                    <div class="mt-2">
                        <h5>Poin Pelanggaran: <span class="badge bg-danger">{{ $totalPoinPelanggaran }}</span></h5>
                        <h5>Poin Prestasi: <span class="badge bg-success">{{ $totalPoinPrestasi }}</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Sanksi yang Sedang Berjalan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-danger">
                                <tr>
                                    <th>Pelanggaran</th>
                                    <th>Jenis Sanksi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sanksiAktifList as $s)
                                <tr>
                                    <td>{{ Str::limit($s->sanksi->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-', 25) }}</td>
                                    <td>{{ Str::limit($s->sanksi->jenis_sanksi ?? '-', 20) }}</td>
                                    <td><span class="badge bg-warning">Proses</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada sanksi aktif</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <i class="fas fa-clock me-1"></i>
                    Pelanggaran Terbaru Saya
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-warning">
                                <tr>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggaranTerbaru as $p)
                                <tr>
                                    <td>{{ Str::limit($p->jenisPelanggaran->nama_pelanggaran ?? '-', 25) }}</td>
                                    <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
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
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-trophy me-1"></i>
                    Prestasi Terbaru Saya
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Prestasi</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prestasiTerbaru as $p)
                                <tr>
                                    <td>{{ Str::limit($p->jenisPrestasi->nama_prestasi ?? '-', 25) }}</td>
                                    <td><span class="badge bg-success">{{ $p->poin ?? 0 }}</span></td>
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
                backgroundColor: ['#FF8040', '#28a745'],
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
