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
                            <a class="nav-link" href="/bk/bk">
                                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                Input Konseling
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Reports</div>
                            <a class="nav-link" href="{{ route('bk.notifications.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                                Notifikasi
                            </a>
                            <a class="nav-link" href="/bk/export">
                                <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                                Export Laporan
                            </a>
                        </div>
                    </div>
                </nav>
            </div>