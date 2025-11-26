            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="/dashboard">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Data Management</div>
                            <a class="nav-link" href="/guru/pelanggaran">
                                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                Input Pelanggaran
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Reports</div>
                            <a class="nav-link" href="{{ route('guru.notifications.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                                Notifikasi
                            </a>
                            <a class="nav-link" href="/guru/export">
                                <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                                Export Laporan
                            </a>
                        </div>
                    </div>
                </nav>
            </div>