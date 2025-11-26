<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/templatemo-digimedia-v3.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/admin/css/custom-admin.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/admin/css/notification.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/admin/css/profile-modal.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 d-flex align-items-center" href="/dashboard" style="color: #007bff;">
                <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px;">
                <span style="color: #4A70A9; font-weight: bold;">Web Kesiswaan</span>
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0">
                <li class="nav-item dropdown me-3 notification-badge">
                    <a class="nav-link" href="@if(auth()->user()->level == 'admin') {{ route('admin.notifications.index') }} @elseif(auth()->user()->level == 'kesiswaan') {{ route('kesiswaan.notifications.index') }} @elseif(auth()->user()->level == 'kepsek') {{ route('kepsek.notifications.index') }} @elseif(auth()->user()->level == 'guru') {{ route('guru.notifications.index') }} @elseif(auth()->user()->level == 'wali_kelas') {{ route('walas.notifications.index') }} @elseif(auth()->user()->level == 'bk') {{ route('bk.notifications.index') }} @elseif(auth()->user()->level == 'ortu') {{ route('ortu.notifications.index') }} @elseif(auth()->user()->level == 'siswa') {{ route('siswa.notifications.index') }} @endif">
                        <i class="fas fa-bell fa-fw"></i>
                        @if(auth()->user()->unreadNotificationCount > 0)
                            <span class="badge bg-danger">{{ auth()->user()->unreadNotificationCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i>
                        <span class="d-none d-md-inline">{{ auth()->user()->profileData['nama'] ?? auth()->user()->username }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">

            @if(auth()->user()->level == 'admin')
                @include('admin.partials.sidebar')
            @elseif(auth()->user()->level == 'kesiswaan')
                @include('kesiswaan.partials.sidebar')
            @elseif(auth()->user()->level == 'kepsek')
                @include('kepsek.partials.sidebar')
            @elseif(auth()->user()->level == 'guru')
                @include('guru.partials.sidebar')
            @elseif(auth()->user()->level == 'wali_kelas')
                @include('walas.partials.sidebar')
            @elseif(auth()->user()->level == 'bk')
                @include('bk.partials.sidebar')
            @elseif(auth()->user()->level == 'siswa')
                @include('siswa.partials.sidebar')
            @elseif(auth()->user()->level == 'ortu')
                @include('ortu.partials.sidebar')
            @endif

            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>

                @include('partials.profile-modal')
                @include('partials.footer')
                
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/admin/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('assets/admin/demo/chart-bar-demo.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/admin/js/datatables-simple-demo.js') }}"></script>
    </body>
</html>
