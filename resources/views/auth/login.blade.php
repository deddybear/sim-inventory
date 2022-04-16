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

    .navbar-bg {
      background: none !important;
    }

    body {
      background-image: url('/images/background-cutter.jpg');
      background-size: cover;
      height: 100%;
    }
</style>
@endsection

@section('content')
      <div class="col-5 mx-auto">
        <div class="login-brand">
            <img src="{{ asset('/images/logo.png') }}" alt="logo" width="100" class="shadow-light rounded-circle">
            <div class="text-dark text-center mt-3">Menu Login</div>
            <div class="text-dark text-center font-weight-bold">Sistem Informasi Manajemen Gudang</div>
            <div class="text-dark text-center font-weight-bold">PT. Multi Garmen Jaya</div>
        </div>
          <div class="card shadow-lg">
            <div class="card-body">
              <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                  <label for="email">Username</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Username" name="name" >
                 
                  @error('name')
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
                        <a href="/password/reset" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                  </div>
                </div>                 
  
                <div class="form-group mt-5">
                  <button type="submit" class="btn btn-success btn-lg btn-block" tabindex="4">
                    Login
                  </button>
                </div>
              </form>  
            </div>
          </div>    
      </div>
@endsection
