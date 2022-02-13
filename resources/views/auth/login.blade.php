@extends('layouts.app')

@section('title', "Login - Page ")

@section('css')
<style>
    body {
        background-color: #EEEEEE;
    }

    .main-content {
      padding-left: 0 !important;
      padding-right: 0 !important;
    }
</style>
@endsection

@section('content')
      <div class="col-3 mx-auto">
        <div class="login-brand">
            <img src="{{ asset('/plugins/stisla/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>
            
          <div class="card card-primary">
            <div class="card-header"><h4><b>SIM</b> - Inventory</h4></div>
            <div class="card-body">
              <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" >
                 
                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
  
                <div class="form-group">
                  <label for="password" class="control-label">Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" >
                  
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="d-block"> 
                      <div class="float-right">
                        <a href="#" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                  </div>
                </div>                 
  
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Login
                  </button>
                </div>
              </form>  
            </div>
          </div>    
      </div>
@endsection
