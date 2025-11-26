            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="/dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Master Data</div>
                            <a class="nav-link" href="/admin/guru">
                                <div class="sb-nav-link-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                                Data Guru
                            </a>
                            <a class="nav-link" href="/admin/siswa">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                                Data Siswa
                            </a>
                            <a class="nav-link" href="/admin/orangtua">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Data Orangtua
                            </a>
                            <a class="nav-link" href="/admin/kelas">
                                <div class="sb-nav-link-icon"><i class="fas fa-school"></i></div>
                                Data Kelas
                            </a>
                            <a class="nav-link" href="/admin/tahun-ajaran">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                                Tahun Ajaran
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Konfigurasi</div>
                            <a class="nav-link" href="/admin/jenis-pelanggaran">
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Jenis Pelanggaran
                            </a>
                            <a class="nav-link" href="/admin/jenis-sanksi">
                                <div class="sb-nav-link-icon"><i class="fas fa-balance-scale"></i></div>
                                Jenis Sanksi
                            </a>
                            <a class="nav-link" href="/admin/jenis-prestasi">
                                <div class="sb-nav-link-icon"><i class="fas fa-award"></i></div>
                                Jenis Prestasi
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Transaksi</div>
                            <a class="nav-link" href="/admin/pelanggaran">
                                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                Data Pelanggaran
                            </a>
                            <a class="nav-link" href="/admin/prestasi">
                                <div class="sb-nav-link-icon"><i class="fas fa-trophy"></i></div>
                                Data Prestasi
                            </a>
                            <a class="nav-link" href="/admin/sanksi">
                                <div class="sb-nav-link-icon"><i class="fas fa-gavel"></i></div>
                                Data Sanksi
                            </a>
                            <a class="nav-link" href="{{ route('admin.pelaksanaan-sanksi.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                                Pelaksanaan Sanksi
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Verifikasi & Monitoring</div>
                            <a class="nav-link" href="/admin/verifikasi">
                                <div class="sb-nav-link-icon"><i class="fas fa-check-circle"></i></div>
                                Verifikasi Data
                            </a>
                            <a class="nav-link" href="/admin/monitoring">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Monitoring
                            </a>
                            <a class="nav-link" href="/admin/bk">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                Data BK
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Laporan</div>
                            <a class="nav-link" href="/admin/export">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-export"></i></div>
                                Export Laporan
                            </a>
                            <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                                Notifikasi
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">System</div>
                            <a class="nav-link" href="/admin/users">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Manage User
                            </a>
                            <a class="nav-link" href="/admin/backup">
                                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                                Backup System
                            </a>
                        </div>
                    </div>
                </nav>
            </div>