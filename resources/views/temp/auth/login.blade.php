@extends('layouts.app')

@section('title', "Login - Page ")

@section('content')
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>SIM</b> - Inventory</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"></p>
                @if ($pesan = Session::get('sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $pesan }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" >
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                          </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" >
                        <div class="input-group-append">
                          <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                          </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-4 mx-auto">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
