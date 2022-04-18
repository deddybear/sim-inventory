@extends('layouts.app')

@section('title', 'Dashboard SIM - Laporan')
@section('title-header', 'Laporan')

@section('css')
<style>
    .margin-button {
        margin-bottom: 2rem !important;
        margin-top: 2rem !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.css') }}">
@endsection

@section('script')
<script src="{{ asset('/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
<script src="{{ asset('/pages/laporan/script.js') }}"></script>
@endsection

@section('content')
<div class="justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg">
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-4">
                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link" id="masuk-tab4" data-toggle="tab" href="#masuk" role="tab" aria-controls="masuk" aria-selected="true">Bahan Baku (Masuk)</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Bahan Baku (Keluar)</a>
                  </li>
                  @if (Auth::user()->roles == '1')
                  <li class="nav-item">
                    <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Bahan Baku</a>
                  </li>
                  @endif
                </ul>
              </div>
              <div class="col-12 col-sm-12 col-md-8">
                <div class="tab-content no-padding" id="myTab2Content">
                 @if (Auth::user()->roles == '1')
                    <div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                       @if (count($errors) > 0)
                       <div class="my-3">
                           <div class="alert alert-danger">
                               <ul>
                                   @foreach ($errors->all() as $error)
                                       <li>{{ $error }}</li>
                                   @endforeach
                               </ul>
                           </div>
                       </div> 
                       @endif
                       <div class="card shadow-none">
                           <div class="card-header">
                               <h4>Bahan Baku</h4>
                           </div>
                           <div class="card-body">
                               <p>Laporan ini otomatis generate sesuai dengan Data Bahan Baku.</p>
                               <div class="mt-5">
                                   <form action="/laporan/bb" method="POST" target="_blank">
                                       @csrf
                                       <div class="form-row">
                                           <div class="form-group col-12 col-lg-4">
                                               <label for="bulan">Bulan</label>
                                               <div class="input-group date bulan" id="datetimepicker" data-target-input="nearest">
                                                   <input name="month" type="number" min="1" max="12" class="form-control datetimepicker-input" data-target="#datetimepicker"/>
                                                   <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                                       <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="form-group col-12 col-lg-4">
                                               <label for="tahun">Tahun</label>
                                               <div class="input-group date tahun" id="datetimepicker1" data-target-input="nearest">
                                                   <input name="year" type="number" min="1" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                                                   <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                       <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="form-group col-12 col-lg-4">
                                               <button type="submit" class="margin-button btn btn-success"><i class="fas fa-download"></i> Download Laporan</button>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                     </div>
                 @endif

                  <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                    @if (count($errors) > 0)
                    <div class="my-3">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div> 
                    @endif
                    <div class="card shadow-none">
                        <div class="card-header">
                            <h4>Bahan Baku Keluar</h4>
                        </div>
                        <div class="card-body">
                            <p>Laporan ini otomatis generate sesuai dengan transaksi yang telah dilakukan pada halaman History.</p>
                            <div class="mt-5">
                                <form action="/laporan/bbkeluar" method="POST" target="_blank">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-12 col-lg-4">
                                            <label for="bulan">Bulan</label>
                                            <div class="input-group date bulan" id="datetimepicker2" data-target-input="nearest">
                                                <input name="month" type="number" min="1" max="12" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                                                <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-lg-4">
                                            <label for="tahun">Tahun</label>
                                            <div class="input-group date tahun" id="datetimepicker3" data-target-input="nearest">
                                                <input name="year" type="number" min="1" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                                <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-lg-4">
                                            <button type="submit" class="margin-button btn btn-success"><i class="fas fa-download"></i> Download Laporan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="masuk" role="tabpanel" aria-labelledby="masuk-tab4">
                    @if (count($errors) > 0)
                    <div class="my-3">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div> 
                    @endif
                    <div class="card shadow-none">
                        <div class="card-header">
                            <h4>Bahan Baku Masuk</h4>
                        </div>
                        <div class="card-body">
                            <p>Laporan ini otomatis generate sesuai dengan transaksi yang telah dilakukan pada halaman History.</p>
                            <div class="mt-5">
                                <form action="/laporan/bbmasuk" method="POST" target="_blank">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-12 col-lg-4">
                                            <label for="bulan">Bulan</label>
                                            <div class="input-group date bulan" id="datetimepicker4" data-target-input="nearest">
                                                <input name="month" type="number" min="1" max="12" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                                                <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-lg-4">
                                            <label for="tahun">Tahun</label>
                                            <div class="input-group date tahun" id="datetimepicker5" data-target-input="nearest">
                                                <input name="year" type="number" min="1" class="form-control datetimepicker-input" data-target="#datetimepicker5"/>
                                                <div class="input-group-append" data-target="#datetimepicker5" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 col-lg-4">
                                            <button type="submit" class="margin-button btn btn-success"><i class="fas fa-download"></i> Download Laporan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                  </div>
                 

                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
