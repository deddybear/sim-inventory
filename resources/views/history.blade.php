@extends('layouts.app')

@section('title', 'Dashboard SIM - Inventory')
@if (request()->is('dashboard/history/out'))
    @section('title-header', 'History Pengeluaran Bahan Baku Gudang')
@else
    @section('title-header', 'History Pemasukan Bahan Baku Gudang')
@endif


@section('css')
<link rel="stylesheet" href="{{ asset('/plugins/dataTables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.css') }}">
<style>
    .margin-button {
        margin-bottom: 2rem !important;
        margin-top: 2rem !important;
    }
</style>
@endsection

@section('script')
<script src="{{ asset('/plugins/moment-with-locales.js') }}"></script>  
<script src="{{ asset('/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('/plugins/dataTables/datatables.js') }}"></script>
@if (request()->is('dashboard/history/out'))
    <script src="{{ asset('/pages/history/keluar.js') }}"></script>
@else
<script src="{{ asset('/pages/history/masuk.js') }}"></script>
@endif
@endsection

@section('content')
<div class="row justrify-content-center">
    <div class="col-12">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama Bahan Baku</th>
                                <th>Deskripsi</th>
                                <th>Kuantitas</th>   
                                <th>Aksi</th>                                 
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <th><input type="text" class="date text-sm form-control" placeholder="Search Date"></th>
                            <th></th>
                            <th></th>
                            <th></th>                        
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
 
        <div class="card shadow-lg">
            <div class="card-body">
                <h5>Hapus Periode Data</h5>
                <div class="mt-5">
                    <form id="form" method="POST">
                        @csrf
                        @method('delete')
                        <div class="form-row">
                            <div class="form-group col-12 col-lg-3">
                                <label for="bulan">Bulan</label>
                                <div class="input-group" id="bulan" data-target-input="nearest">
                                    <input name="month" type="number" class="form-control datetimepicker-input" data-target="#bulan"/>
                                    <div class="input-group-append" data-target="#bulan" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-3">
                                <label for="tahun">Tahun</label>
                                <div class="input-group" id="tahun" data-target-input="nearest">
                                    <input name="year" type="number" class="form-control datetimepicker-input" data-target="#tahun"/>
                                    <div class="input-group-append" data-target="#tahun" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-3">
                                <button type="submit" class="margin-button btn btn-danger">Hapus Data Periode</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
    </div>  
</div>
@endsection