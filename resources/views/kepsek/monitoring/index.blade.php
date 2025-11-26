@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Monitoring Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('kepsek.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Monitoring</li>
    </ol>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="monitoringTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pelanggaran-tab" data-bs-toggle="tab" data-bs-target="#pelanggaran" type="button">
                <i class="fas fa-exclamation-triangle"></i> Pelanggaran
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button">
                <i class="fas fa-trophy"></i> Prestasi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="konseling-tab" data-bs-toggle="tab" data-bs-target="#konseling" type="button">
                <i class="fas fa-comments"></i> BK
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pelaksanaan-sanksi-tab" data-bs-toggle="tab" data-bs-target="#pelaksanaan-sanksi" type="button">
                <i class="fas fa-tasks"></i> Pelaksanaan Sanksi
            </button>
        </li>
    </ul>

    <div class="tab-content" id="monitoringTabContent">
        <!-- Tab Pelanggaran -->
        <div class="tab-pane fade show active" id="pelanggaran" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Data Pelanggaran
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablePelanggaran">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Pencatat</th>
                                    <th>Catatan Kepsek</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggarans as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $p->poin }}</span></td>
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
                                    <td>{{ $p->guruPencatat->guru->nama_guru ?? '-' }}</td>
                                    <td>
                                        @if($p->monitoring && $p->monitoring->catatan)
                                            <span class="badge bg-info">Ada Catatan</span>
                                            <small class="d-block text-muted">{{ Str::limit($p->monitoring->catatan, 50) }}</small>
                                        @else
                                            <span class="text-muted">Belum ada catatan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#catatanModal{{ $p->id }}">
                                            <i class="fas fa-comment"></i> {{ $p->monitoring ? 'Edit' : 'Tambah' }}
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Tidak ada data pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Modal Catatan -->
                    @foreach($pelanggarans as $p)
                    <div class="modal fade" id="catatanModal{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('kepsek.monitoring.update', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Catatan Monitoring - {{ $p->siswa->nama_siswa }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Pelanggaran</label>
                                            <div class="form-control-plaintext">{{ $p->jenisPelanggaran->nama_pelanggaran }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Guru Pencatat</label>
                                            <div class="form-control-plaintext">{{ $p->guruPencatat->guru->nama_guru ?? '-' }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status{{ $p->id }}" class="form-label">Status Monitoring</label>
                                            <select class="form-select" id="status{{ $p->id }}" name="status" required>
                                                <option value="dipantau" {{ ($p->monitoring && $p->monitoring->status == 'dipantau') ? 'selected' : '' }}>Dipantau</option>
                                                <option value="ditindaklanjuti" {{ ($p->monitoring && $p->monitoring->status == 'ditindaklanjuti') ? 'selected' : '' }}>Ditindaklanjuti</option>
                                                <option value="selesai" {{ ($p->monitoring && $p->monitoring->status == 'selesai') ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="catatan{{ $p->id }}" class="form-label">Catatan Kepala Sekolah</label>
                                            <textarea class="form-control" id="catatan{{ $p->id }}" name="catatan" rows="4" required placeholder="Masukkan catatan monitoring...">{{ $p->monitoring->catatan ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tab Prestasi -->
        <div class="tab-pane fade" id="prestasi" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-trophy me-1"></i>
                    Data Prestasi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablePrestasi">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Prestasi</th>
                                    <th>Poin</th>
                                    <th>Tanggal</th>
                                    <th>Pencatat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($prestasis as $key => $p)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $p->jenisPrestasi->nama_prestasi ?? '-' }}</td>
                                    <td><span class="badge bg-info">{{ $p->poin ?? '-' }}</span></td>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $p->guru->guru->nama_guru ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data prestasi terverifikasi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Bimbingan Konseling -->
        <div class="tab-pane fade" id="konseling" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-comments me-1"></i>
                    Data Konseling
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableKonseling">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pelanggaran</th>
                                    <th>Tindakan</th>
                                    <th>Tanggal</th>
                                    <th>Konselor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bk as $key => $bk)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $bk->siswa->nama_siswa ?? '-' }}</td>
                                    <td>{{ $bk->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $bk->pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                    <td>{{ $bk->tindakan ?? '-' }}</td>
                                    <td>{{ $bk->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $bk->bk->guru->nama_guru ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Tidak ada data konseling</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Pelaksanaan Sanksi -->
        <div class="tab-pane fade" id="pelaksanaan-sanksi" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-1"></i>
                    Data Pelaksanaan Sanksi
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablePelaksanaanSanksi">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis Sanksi</th>
                                    <th>Status</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelaksanaanSanksis ?? [] as $key => $ps)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $ps->sanksi?->pelanggaran?->siswa?->nama_siswa ?? '-' }}</td>
                                    <td>{{ $ps->sanksi?->pelanggaran?->siswa?->kelas?->nama_kelas ?? '-' }}</td>
                                    <td>{{ $ps->sanksi->jenis_sanksi ?? '-' }}</td>
                                    <td>
                                        @php
                                            $status = $ps->status ?? 'pending';
                                            $badgeClass = match($status) {
                                                'selesai' => 'bg-success',
                                                'berlangsung' => 'bg-warning',
                                                'pending' => 'bg-secondary',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                    </td>
                                    <td>{{ $ps->tanggal_mulai ? \Carbon\Carbon::parse($ps->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $ps->tanggal_selesai ? \Carbon\Carbon::parse($ps->tanggal_selesai)->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($ps->bukti)
                                            <a href="{{ asset($ps->bukti) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data pelaksanaan sanksi</td>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#tablePelanggaran').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
        $('#tablePrestasi').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
        $('#tableKonseling').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
        $('#tablePelaksanaanSanksi').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    }
});
</script>
@endsection
