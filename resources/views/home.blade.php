@extends('layouts.app')

@section('title', 'Dashboard SIM - Inventory')
@section('title-header', 'Dashboard')

@section('script')
    {{-- <script src="{{ asset('/plugins/chartjs/chart.js') }}"></script> --}}
    {{-- <script src="{{ asset('/pages/home/script.js') }}"></script> --}}
    @if (Auth::user()->roles == '1')
    <script src="{{ asset('/pages/home/spv.js') }}"></script>
    @endif
@endsection

@section('content')
    <div class="card shadow-lg">
        <div class="mx-auto my-5">
            <div class="mx-auto col-5 mb-4">
                <img src="{{ asset('/images/logo.png') }}" alt="logo" >
            </div>
            <h3 class="text-center">SELAMAT DATANG DI</h3>
            <h3 class="text-center">SISTEM INFORMASI MANAJEMEN GUDANG</h3>
            <h3 class="text-center">PT. MULTI GARMEN JAYA</h3>
            <hr class="lineCustom">
            <p class="text-center">Jl. Moh. Toha No.215, Citeureup, Kec. Dayeuhkolot, Kota Bandung, Jawa Barat 40258    </p>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow-lg">
                <div class="card-header">Grafik Pemasukan Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pemasukanbb"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card shadow-lg">
                <div class="card-header">Grafik Pengeluaran Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pengeluaranbb"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card shadow-lg">
                <div class="card-header">Grafik Pemasukan Jenis Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pemasukanjenis"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card shadow-lg">
                <div class="card-header">Grafik Pengeluaran Jenis Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pengeluaranjenis"></canvas>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
