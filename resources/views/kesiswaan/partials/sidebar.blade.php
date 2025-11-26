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
            <a class="nav-link" href="/kesiswaan/pelanggaran">
                <div class="sb-nav-link-icon"><i class="fas fa-exclamation-triangle"></i></div>
                Data Pelanggaran
            </a>
            <a class="nav-link" href="/kesiswaan/prestasi">
                <div class="sb-nav-link-icon"><i class="fas fa-trophy"></i></div>
                Data Prestasi
            </a>
            <a class="nav-link" href="/kesiswaan/verifikasi">
                <div class="sb-nav-link-icon"><i class="fas fa-check-circle"></i></div>
                Verifikasi Data
            </a>
            <a class="nav-link" href="{{ route('kesiswaan.sanksi.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-gavel"></i></div>
                Data Sanksi
            </a>
            <a class="nav-link" href="{{ route('kesiswaan.pelaksanaan-sanksi.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                Pelaksanaan Sanksi
            </a>
            
            <div class="sb-sidenav-menu-heading">Reports</div>
            <a class="nav-link" href="{{ route('kesiswaan.monitoring.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                Monitoring
            </a>
            <a class="nav-link" href="{{ route('kesiswaan.notifications.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                Notifikasi
            </a>
            <a class="nav-link" href="/kesiswaan/export">
                <div class="sb-nav-link-icon"><i class="fas fa-download"></i></div>
                Export Laporan
            </a>
            </div>
        </div>
    </nav>
</div>