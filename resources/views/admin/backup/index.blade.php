@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Database Backup System</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Daily Backups</h5>
                    <h2>{{ $backupStats['daily'] }}</h2>
                    <small>Incremental (00:00)</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Weekly Backups</h5>
                    <h2>{{ $backupStats['weekly'] }}</h2>
                    <small>Full (Minggu 02:00)</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5>Monthly Backups</h5>
                    <h2>{{ $backupStats['monthly'] }}</h2>
                    <small>Archive (Akhir bulan)</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5>Total Size</h5>
                    <h2>{{ number_format($backupStats['total_size'] / 1024 / 1024, 2) }} MB</h2>
                    <small>All backups</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Create Manual Backup
        </div>
        <div class="card-body">
            <form action="{{ route('admin.backup.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label">Backup Type</label>
                    <select name="type" class="form-select" required>
                        <option value="daily">Daily Incremental</option>
                        <option value="weekly">Weekly Full</option>
                        <option value="monthly">Monthly Archive</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-database"></i> Create Backup Now
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Backup History
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Filename</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>Backup Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $index => $backup)
                    <tr>
                        <td>{{ $backups->firstItem() + $index }}</td>
                        <td><code>{{ $backup->filename }}</code></td>
                        <td>
                            @if($backup->type == 'daily')
                                <span class="badge bg-primary">Daily</span>
                            @elseif($backup->type == 'weekly')
                                <span class="badge bg-success">Weekly</span>
                            @else
                                <span class="badge bg-warning">Monthly</span>
                            @endif
                        </td>
                        <td>{{ number_format($backup->size / 1024 / 1024, 2) }} MB</td>
                        <td>{{ $backup->backup_date->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('admin.backup.download', $backup->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-download"></i> Download
                            </a>
                            <form action="{{ route('admin.backup.restore', $backup->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('PERINGATAN: Restore akan mengganti semua data database dengan backup ini. Lanjutkan?')">
                                    <i class="fas fa-undo"></i> Restore
                                </button>
                            </form>
                            <form action="{{ route('admin.backup.destroy', $backup->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus backup ini?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada backup</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $backups->links() }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-terminal me-1"></i>
                    Auto Backup Script
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Untuk mengaktifkan backup otomatis, tambahkan ke crontab:</strong></p>
                    <pre class="bg-light p-3 rounded"><code># Daily incremental backup (00:00)
0 0 * * * cd {{ base_path() }} && php artisan backup:run --type=daily

# Weekly full backup (Minggu 02:00)
0 2 * * 0 cd {{ base_path() }} && php artisan backup:run --type=weekly

# Monthly archive backup (Akhir bulan)
0 3 L * * cd {{ base_path() }} && php artisan backup:run --type=monthly</code></pre>
                    <p class="text-muted mt-2"><small>Note: Backup otomatis akan menghapus backup daily yang lebih dari 30 hari</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-undo me-1"></i>
                    Proses Restore Manual
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Untuk restore database secara manual via terminal:</strong></p>
                    <pre class="bg-light p-3 rounded"><code># 1. Extract backup file
gunzip backup_file.sql.gz

# 2. Restore database
mysql -u {{ env('DB_USERNAME') }} -p {{ env('DB_DATABASE') }} &lt; backup_file.sql

# 3. Verification
mysql -u {{ env('DB_USERNAME') }} -p
USE {{ env('DB_DATABASE') }};
SHOW TABLES;
SELECT COUNT(*) FROM pelanggaran;</code></pre>
                    <p class="text-muted mt-2"><small>Atau gunakan tombol "Restore" di tabel untuk restore otomatis</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
