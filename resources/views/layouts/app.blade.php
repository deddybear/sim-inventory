<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/plugins/jquery-ui/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/ionicons/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/adminlte/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome/all.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/loader.min.css') }}">


    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- <div id="loader-wrapper">
	    <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>  --}}
    <div id="wrapper">
        @auth
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item d-none d-sm-inline-block">
                        <p class="nav-link m-0" > Selamat datang, {{ Auth::user()->name }} </p>
                    </li>
                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="/" class="brand-link">
                    <span class="brand-text font-weight-light primary">SIM - Inventory </span>
                </a>
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">                           
                            
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard/gudang" class="nav-link">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>Gudang Bahan Baku</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard/history" class="nav-link">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/dashboard/laporan" class="nav-link">
                                    <i class="nav-icon far fa-file-alt"></i>
                                    <p>Download Laporan</p>
                                </a>
                            </li>                         
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Pengaturan Akun
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if (Auth::user()->roles == 1)
                                    <li class="nav-item">
                                        <a href="/dashboard/karyawan" class="nav-link">
                                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                            <p> Data Pegawai</p>
                                        </a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a href="/" class="nav-link">
                                            <i class="fas fa-user-edit nav-icon"></i>
                                            <p>Edit Akun</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('password.request') }}" class="nav-link">
                                            <i class="fas fa-wrench nav-icon"></i>
                                            <p>Reset Password</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt nav-icon"></i>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                    <p>Logout</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
        @endauth
        @auth
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('title-header')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php 
                                    $link = '';
                                ?>
                                @for ($i = 1; $i <= count(Request::segments()); $i++)
                                    @if ($i < count(Request::segments()) & $i > 0)
                                        <?php $link .= "/" . Request::segment($i); ?>
                                        <li class="breadcrumb-item"><a href="{{ $link }}">{{ ucwords(str_replace('-', '', Request::segment($i))) }}</a></li>
                                    @else
                                        <li class="breadcrumb-item active">{{ ucwords(str_replace('-', '', Request::segment($i))) }}</li>
                                    @endif
                                @endfor
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @endauth        
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>  
        </div>
         
        
    </div>
</body>
<script src="{{ asset('/plugins/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('/plugins/adminlte/adminlte.js') }}"></script>
<script src="{{ asset('/plugins/popper.min.js') }}"></script>
<script src="{{ asset('/plugins/fontawesome/all.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
<script src="{{ asset('/plugins/moment-with-locales.js') }}"></script>
<script src="https://momentjs.com/downloads/moment-timezone-with-data-1970-2030.min.js"></script>
@yield('script')
</html>