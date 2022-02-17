@extends('layouts.app')

@section('title', 'Dashboard SIM - Inventory')
@section('title-header', 'Gudang Bahan Baku')

@section('css')
<link rel="stylesheet" href="{{ asset('/plugins/dataTables/datatables.css') }}">
<link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.css') }}">
@endsection

@section('script')
<script src="{{ asset('/plugins/moment-with-locales.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('/plugins/dataTables/datatables.js') }}"></script>
<script src="{{ asset('/pages/gudang/script.js') }}"></script>
@endsection

@section('content')
<div class="row justrify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="pull-right my-3" style="float: right">
                    <a id="add" href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_form">
                        <span class="fa fa-plus"></span> Tambahkan Data
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap" id="dataTable">
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>Nama Bahan Baku</th>
                                <th>Jenis</th>
                                <th>Kuantitas</th>
                                <th>Satuan</th>
                                <th>Harga Satuan</th>
                                <th>Total</th>
                                <th>Waktu Terakhir Masuk</th>
                                <th>Waktu Terakhir Keluar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><input type="text" class="date text-sm form-control" placeholder="Search Date"></th>
                            <th><input type="text" class="date text-sm form-control" placeholder="Search Date"></th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="1050"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 500px !important">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="result"></span>
                <form class="form-horizontal" id="form">
                    <div class="form-body p-3">

                        {{-- Kode Bahan Baku --}}
                        {{-- <div class="form-group">
                            <label class="control-label col-md-5">Kode Bahan Baku</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="kode" id="kode"
                                    placeholder="Kode Bahan Baku" required>
                            </div>
                        </div> --}}

                        {{-- Nama Bahan Baku --}}
                        <div class="form-group">
                            <label class="control-label col-md-5">Nama Bahan Baku</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Nama Bahan Baku" required>
                            </div>
                        </div>

                        {{-- Jenis --}}
                        <div class="form-group">
                            <label class="control-label col-md-5">Jenis</label>
                            <div class="col-md-12">
                                <select id="list-type" class="form-control" name="type" required>
                                    <option value="" selected>Silahkan Dipilih</option>
                                    @foreach ($listType as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Satuan --}}
                        <div class="form-group">
                            <label class="control-label col-md-5">Satuan</label>
                            <div class="col-md-12">
                                <select id="list-unit" class="form-control" name="unit" required>
                                    <option value="" selected>Silahkan Dipilih</option>
                                    @foreach ($listUnit as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Kuantitas --}}
                        <div class="form-group">
                            <label class="control-label col-md-5">Kuantitas</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control" name="qty" id="qty" min="1" max="1000"
                                    placeholder="Kuantitas" required>
                            </div>
                        </div>

                        {{-- Harga Satuan --}}
                        <div class="form-group">
                            <label class="control-label col-md-5">Harga Satuan</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control" name="price" id="price" min="1" max="1000"
                                    placeholder="Harga Satuan" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button id="btn-cancel" type="button" class="btn btn-secondary" data-dismiss="modal"></button>
                        <button id="btn-confrim" type="submit" class="btn btn-primary"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
