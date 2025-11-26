<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IndexController;


//Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\BkController;
use App\Http\Controllers\Admin\VerifikasiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\JenisPelanggaranController;
use App\Http\Controllers\Admin\SanksiController;
use App\Http\Controllers\Admin\PelaksanaanSanksiController;
use App\Http\Controllers\Admin\JenisSanksiController;
use App\Http\Controllers\Admin\JenisPrestasiController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\OrangtuaController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Admin\NotificationController;

//Kesiswaan Controllers
use App\Http\Controllers\Kesiswaan\DashboardController as KesiswaanDashboardController;
use App\Http\Controllers\Kesiswaan\PelanggaranController as KesiswaanPelanggaranController;
use App\Http\Controllers\Kesiswaan\PrestasiController as KesiswaanPrestasiController;
use App\Http\Controllers\Kesiswaan\VerifikasiController as KesiswaanVerifikasiController;
use App\Http\Controllers\Kesiswaan\MonitoringController as KesiswaanMonitoringController;
use App\Http\Controllers\Kesiswaan\ExportController as KesiswaanExportController;
use App\Http\Controllers\Kesiswaan\NotificationController as KesiswaanNotificationController;
use App\Http\Controllers\Kesiswaan\SanksiController as KesiswaanSanksiController;
use App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController as KesiswaanPelaksanaanSanksiController;

//Kepsek Controllers
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboardController;
use App\Http\Controllers\Kepsek\MonitoringController as KepsekMonitoringController;
use App\Http\Controllers\Kepsek\ExportController as KepsekExportController;
use App\Http\Controllers\Kepsek\NotificationController as KepsekNotificationController;

//Guru Controllers
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\PelanggaranController as GuruPelanggaranController;
use App\Http\Controllers\Guru\ExportController as GuruExportController;
use App\Http\Controllers\Guru\NotificationController as GuruNotificationController;

//Wali Kelas Controllers
use App\Http\Controllers\Walas\DashboardController as WaliKelasDashboardController;
use App\Http\Controllers\Walas\PelanggaranController as WaliKelasPelanggaranController;
use App\Http\Controllers\Walas\SiswaController as WaliKelasSiswaController;
use App\Http\Controllers\Walas\ExportController as WaliKelasExportController;
use App\Http\Controllers\Walas\PelaksanaanSanksiController as WalasPelaksanaanSanksiController;
use App\Http\Controllers\Walas\NotificationController as WaliKelasNotificationController;

//BK Controllers
use App\Http\Controllers\Bk\DashboardController as BkDashboardController;
use App\Http\Controllers\Bk\BkController as BkBkController;
use App\Http\Controllers\Bk\ExportController as BkExportController;
use App\Http\Controllers\Bk\NotificationController as BkNotificationController;

//Ortu Controllers
use App\Http\Controllers\Ortu\DashboardController as OrtuDashboardController;
use App\Http\Controllers\Ortu\ExportController as OrtuExportController;
use App\Http\Controllers\Ortu\PelaksanaanSanksiController as OrtuPelaksanaanSanksiController;
use App\Http\Controllers\Ortu\NotificationController as OrtuNotificationController;

//Siswa Controllers
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ExportController as SiswaExportController;
use App\Http\Controllers\Siswa\NotificationController as SiswaNotificationController;
use App\Http\Controllers\Siswa\PelaksanaanSanksiController as SiswaPelaksanaanSanksiController;


// Public routes
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Redirect /dashboard to appropriate prefix based on level
    Route::get('/dashboard', function() {
        $level = auth()->user()->level;
        
        switch($level) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'kesiswaan':
                return redirect('/kesiswaan/dashboard');
            case 'kepsek':
                return redirect('/kepsek/dashboard');
            case 'guru':
                return redirect('/guru/dashboard');
            case 'wali_kelas':
                return redirect('/walas/dashboard');
            case 'bk':
                return redirect('/bk/dashboard');
            case 'ortu':
                return redirect('/ortu/dashboard');
            case 'siswa':
                return redirect('/siswa/dashboard');
            default:
                return redirect()->route('login');
        }
    })->name('dashboard');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/guru', GuruController::class);
        Route::resource('/siswa', SiswaController::class);
        Route::resource('/kelas', KelasController::class);
        Route::resource('/jenis-pelanggaran', JenisPelanggaranController::class);
        Route::resource('/jenis-sanksi', JenisSanksiController::class);
        Route::resource('/jenis-prestasi', JenisPrestasiController::class);
        Route::resource('/tahun-ajaran', TahunAjaranController::class);
        Route::resource('/orangtua', OrangtuaController::class);
        Route::resource('/pelanggaran', PelanggaranController::class)->only(['index']);
        Route::resource('/sanksi', SanksiController::class)->except(['destroy']);
        Route::resource('/pelaksanaan-sanksi', PelaksanaanSanksiController::class)->only(['index']);

        Route::resource('/verifikasi', VerifikasiController::class)->only(['index', 'update']);
        Route::resource('/users', UserController::class);
        Route::get('/monitoring', [MonitoringController::class, 'index']);
        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [BackupController::class, 'backup'])->name('backup.store');
        Route::get('/backup/{id}/download', [BackupController::class, 'download'])->name('backup.download');
        Route::post('/backup/{id}/restore', [BackupController::class, 'restore'])->name('backup.restore');
        Route::delete('/backup/{id}', [BackupController::class, 'destroy'])->name('backup.destroy');
        Route::get('/export', [AdminExportController::class, 'index']);
        Route::get('/export/pelanggaran', [AdminExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [AdminExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [AdminExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [AdminExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

        Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran');
        Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi');
        Route::get('/bk', [BkController::class, 'index'])->name('bk');
        Route::get('/sanksi', [SanksiController::class, 'viewOnly'])->name('sanksi');
    });

});

// Kesiswaan routes
Route::middleware(['auth', 'kesiswaan'])->group(function () {
    Route::prefix('kesiswaan')->name('kesiswaan.')->group(function (){
        Route::get('/dashboard', [KesiswaanDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/verifikasi', KesiswaanVerifikasiController::class);
        Route::resource('/pelanggaran', KesiswaanPelanggaranController::class)->except(['destroy']);
        Route::resource('/prestasi', KesiswaanPrestasiController::class)->except(['destroy']);
        Route::get('/monitoring', [KesiswaanMonitoringController::class, 'index'])->name('monitoring.index');
        Route::resource('/sanksi', KesiswaanSanksiController::class)->except(['destroy']);
        Route::resource('/pelaksanaan-sanksi',KesiswaanPelaksanaanSanksiController::class)->only(['index', 'edit', 'update']);
        Route::get('/export', [KesiswaanExportController::class, 'index']);
        Route::get('/export/pelanggaran', [KesiswaanExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [KesiswaanExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [KesiswaanExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [KesiswaanExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [KesiswaanNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [KesiswaanNotificationController::class, 'markAsRead'])->name('notifications.read');
    });
});

// Kepsek routes
Route::middleware(['auth', 'kepsek'])->group(function () {
    Route::prefix('kepsek')->name('kepsek.')->group(function (){
        Route::get('/dashboard', [KepsekDashboardController::class, 'index'])->name('dashboard');
        Route::get('/monitoring', [KepsekMonitoringController::class, 'index'])->name('monitoring.index');
        Route::put('/monitoring/{pelanggaran}', [KepsekMonitoringController::class, 'update'])->name('monitoring.update');

        Route::get('/export', [KepsekExportController::class, 'index']);
        Route::get('/export/pelanggaran', [KepsekExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [KepsekExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [KepsekExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [KepsekExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [KepsekNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [KepsekNotificationController::class, 'markAsRead'])->name('notifications.read');
    });
});

// Guru routes
Route::middleware(['auth', 'guru'])->group(function () {
    Route::prefix('guru')->name('guru.')->group(function (){
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/pelanggaran', GuruPelanggaranController::class)->except(['destroy']);
        Route::get('/export', [GuruExportController::class, 'index']);
        Route::get('/export/pelanggaran', [GuruExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/surat-sanksi/{id}', [GuruExportController::class, 'suratSanksi'])->name('export.surat-sanksi');

        Route::get('/export/surat-sanksi/{id}', [GuruExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [GuruNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [GuruNotificationController::class, 'markAsRead'])->name('notifications.read');

    });
});

// Wali Kelas routes
Route::middleware(['auth', 'wali_kelas'])->group(function () {
    Route::prefix('walas')->name('walas.')->group(function (){
        Route::get('/dashboard', [WaliKelasDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/pelanggaran', WaliKelasPelanggaranController::class)->except(['destroy']);
        Route::resource('/siswa', WaliKelasSiswaController::class);
        Route::get('/pelaksanaan-sanksi', [WalasPelaksanaanSanksiController::class, 'index'])->name('pelaksanaan-sanksi.index');
        Route::get('/export', [WaliKelasExportController::class, 'index'])->name('export.index');
        Route::get('/export/pelanggaran', [WaliKelasExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [WaliKelasExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [WaliKelasExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [WaliKelasExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [WaliKelasNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [WaliKelasNotificationController::class, 'markAsRead'])->name('notifications.read');

    });
});

// BK routes
Route::middleware(['auth', 'bk'])->group(function () {
    Route::prefix('bk')->name('bk.')->group(function (){
        Route::get('/dashboard', [BkDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/bk', BkBkController::class);
        Route::get('/export', [BkExportController::class, 'index']);
        Route::get('/export/pelanggaran', [BkExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [BkExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [BkExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [BkExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [BkNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [BkNotificationController::class, 'markAsRead'])->name('notifications.read');

    });
});

// Ortu routes
Route::middleware(['auth', 'ortu'])->group(function () {
    Route::prefix('ortu')->name('ortu.')->group(function (){
        Route::get('/dashboard', [OrtuDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pelaksanaan-sanksi', [OrtuPelaksanaanSanksiController::class, 'index']);
        Route::get('/export', [OrtuExportController::class, 'index']);
        Route::get('/export/pelanggaran', [OrtuExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [OrtuExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [OrtuExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [OrtuExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [OrtuNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [OrtuNotificationController::class, 'markAsRead'])->name('notifications.read');

    });
});

// Siswa routes
Route::middleware(['auth', 'siswa'])->group(function () {
    Route::prefix('siswa')->name('siswa.')->group(function (){
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/export', [SiswaExportController::class, 'index']);
        Route::get('/export/pelanggaran', [SiswaExportController::class, 'exportPelanggaran'])->name('export.pelanggaran');
        Route::get('/export/prestasi', [SiswaExportController::class, 'exportPrestasi'])->name('export.prestasi');
        Route::get('/export/surat-sanksi/{id}', [SiswaExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/export/surat-sanksi/{id}', [SiswaExportController::class, 'suratSanksi'])->name('export.surat-sanksi');
        Route::get('/notifications', [SiswaNotificationController::class, 'index'])->name('notifications.index');
        Route::put('/notifications/{id}/read', [SiswaNotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::get('/pelaksanaan-sanksi', [SiswaPelaksanaanSanksiController::class, 'index'])->name('pelaksanaan-sanksi.index');
        Route::put('/pelaksanaan-sanksi/{pelaksanaanSanksi}', [SiswaPelaksanaanSanksiController::class, 'update'])->name('pelaksanaan-sanksi.update');
    });
});