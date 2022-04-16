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

    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/stisla/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/stisla/components.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/jquery-ui/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/ionicons/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/loader.min.css') }}">

    <style>
        .navbar-bg {
            background-color: #20c997 !important;
        }

        hr.lineCustom {
            border: 10px solid #20c997 !important;
            border-radius: 5px !important;
        }
    </style>

    @yield('css')
</head>

<body>
    {{-- <div id="loader-wrapper">
	    <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>  --}}
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
                @auth            
                <nav class="navbar navbar-expand-lg main-navbar">
                    <form class="form-inline mr-auto">
                        <ul class="navbar-nav mr-3">
                            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        </ul>
                    </form>                    
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown"><a data-toggle="dropdown" class="nav-link  nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('avatar-1.png') }}" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
                          </li>
                    </ul>
                </nav>
                <div class="main-sidebar sidebar-style-2">
                    <aside class="sidebar-wrapper">
                        <div class="sidebar-brand">
                            <a href="/">
                                <span class="brand-text font-weight-light">SIM - Inventory </span>
                            </a>
                        </div>
                        <ul class="sidebar-menu">
                            <li class="menu-header">Dashboard</li>
                            <li class="dropdown {{ (request()->is('dashboard')) ? 'active' : '' }}">
                                <a href="/dashboard" class="nav-link">
                                    <i class="fas fa-fire"></i>
                                     <span>Dashboard</span>
                                </a>
                            </li>
                            @if (Auth::user()->roles == "2")
                            <li class="menu-header">Bahan Baku</li>
                            <li class="dropdown {{ request()->segment('2') == 'bahan-baku' ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-boxes"></i>
                                     <span>Bahan Baku</span>
                                </a>
                                <ul class="dropdown-menu">
                                  <li class="{{ request()->segment('3') == 'gudang' ? 'active' : '' }}">
                                      <a class="nav-link" href="/dashboard/bahan-baku/gudang">Manajemen Bahan Baku</a>               
                                  </li>
                                  <li class="{{ request()->segment('3') == 'types' ? 'active' : '' }}">
                                    <a class="nav-link" href="/dashboard/bahan-baku/types">Jenis Bahan Baku</a>     
                                  </li>
                                  <li class="{{ request()->segment('3') == 'units' ? 'active' : '' }}">
                                    <a class="nav-link" href="/dashboard/bahan-baku/units">Satuan Bahan Baku</a>     
                                  </li>
                                  <li class="{{ request()->segment('3') == 'rack' ? 'active' : '' }}">
                                    <a class="nav-link" href="/dashboard/bahan-baku/rack">List Data Rack</a>     
                                  </li>
                                </ul>
                            </li>
                            <li class="dropdown {{ request()->segment('2') == 'history' ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-history"></i>
                                     <span>History</span>
                                </a>
                                <ul class="dropdown-menu">
                                  <li class="{{ request()->segment('3') == 'out' ? 'active' : '' }}">
                                      <a class="nav-link" href="/dashboard/history/out">Bahan Baku (Keluar)</a>                                      
                                  </li>
                                  <li class="{{ request()->segment('3') == 'in' ? 'active' : '' }}">
                                    <a class="nav-link" href="/dashboard/history/in">Bahan Baku (Masuk)</a>
                                  </li>
                                </ul>
                            </li>
                            @endif
                            @if (Auth::user()->roles == "1")
                            <li class="dropdown {{ request()->segment('3') == 'gudang' ? 'active' : '' }}">
                                <a class="nav-link" href="/dashboard/bahan-baku/gudang">
                                    <i class="fas fa-boxes"></i> 
                                    <span>Bahan Baku</span>
                                </a>
                            </li>
                            @endif
                            <li class="dropdown {{ request()->segment('2') == 'laporan' ? 'active' : '' }}">
                                <a class="nav-link" href="/dashboard/laporan">
                                    <i class="far fa-file-alt"></i> 
                                    <span>Laporan</span>
                                </a>
                            </li>
                            <li class="menu-header">Akun Anda</li>
                            <li class="dropdown {{ request()->segment('2') == 'akun' ? 'active' : '' }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                     <span>Pengaturan Akun</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @if (Auth::user()->roles == "1")
                                        <li class="{{ request()->segment('3') == 'karyawan' ? 'active' : '' }}">
                                            <a class="nav-link" href="/dashboard/akun/karyawan">Pengelolah Akun Gudang</a>
                                        </li>
                                    @endif

                                  <li class="{{ request()->segment('3') == 'edit' ? 'active' : '' }}">                                   
                                      <a class="nav-link" href="/dashboard/akun/edit">Edit Akun</a>
                                  </li>
                                  <li>
                                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">                  
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                            Logout
                                        </a>
                                  </li>
                                </ul>
                            </li>
                        </ul>                        
                        {{-- <div class="sidebar">
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
                                        <a href="/dashboard/history" class="nav-link">
                                            <i class="nav-icon fas fa-history"></i>
                                            <p>Jenis Bahan Baku</p>
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
                        </div> --}}
                    </aside>
                </div>
                @endauth
            <div class="main-content">
                <section class="section">
                    @auth
                    <div class="section-header">
                        <h1>@yield('title-header')</h1>
                    </div>
                    @endauth                   
                </section>
                @yield('content')
            </div>  
        </div>
                
    </div>
</body>
<script src="{{ asset('/plugins/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('/plugins/stisla/stisla.js') }}"></script>
<script src="{{ asset('/plugins/stisla/scripts.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('/plugins/popper.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
<script src="{{ asset('/plugins/moment-with-locales.js') }}"></script>
<script src="{{ asset('/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="https://momentjs.com/downloads/moment-timezone-with-data-1970-2030.min.js"></script>
@yield('script')
</html>