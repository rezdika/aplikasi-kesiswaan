<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('kepsek.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                
                <div class="sb-sidenav-menu-heading">Monitoring</div>
                <a class="nav-link" href="{{ route('kepsek.monitoring.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                    Monitoring All
                </a>
                
                <div class="sb-sidenav-menu-heading">Reports</div>
                <a class="nav-link" href="{{ route('kepsek.notifications.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Notifikasi
                </a>
                <a class="nav-link" href="/kepsek/export">
                    <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                    Export Laporan
                </a>
            </div>
        </div>
    </nav>
</div>
