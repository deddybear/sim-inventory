@extends('layouts.app')

@section('title', 'Dashboard SIM - Inventory')
@section('title-header', 'Dashboard')

@section('script')
    <script src="{{ asset('/plugins/chartjs/chart.js') }}"></script>
    <script src="{{ asset('/pages/home/script.js') }}"></script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">Grafik Pemasukan Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pemasukanbb"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">Grafik Pengeluaran Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pengeluaranbb"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">Grafik Pemasukan Jenis Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pemasukanjenis"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">Grafik Pengeluaran Jenis Bahan Baku</div>
                <div class="card-body">
                    <canvas id="pengeluaranjenis"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
