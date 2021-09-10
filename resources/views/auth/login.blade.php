@extends('layouts.master-without-nav')
@section('title')
Login
@endsection
@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <br><br>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{url('index')}}" class="mb-5 d-block auth-logo">
                        <img src="{{ URL::asset('assets/images/LOGO.png')}}" alt="" height="100" class="logo logo-dark">
                        <img src="{{ URL::asset('assets/images/LOGO.png')}}" alt="" height="100" class="logo logo-light">
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">Bienvenido !</h5>
                            <p class="text-muted">Inicia sesion</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="name">{{ __('Usuario') }}</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="usuario" autofocus placeholder="Ingrese su usuario">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="float-right">
                                        @if (Route::has('password.request'))
                                            <a class="text-muted" href="{{ route('password.request') }}">
                                                {{ __('Olvidaste tu contraseña?') }}
                                            </a>
                                        @endif
                                    </div>
                                    <label for="password">{{ __('Contraseña') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Ingresa la contraseña">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <br>
                                <div class="mt-3 text-center">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">{{ __('Iniciar') }}</button>
                                </div>
                                <br>
                                @include('flash::message')
                        
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>© 2021 UNINET.</p>
                </div>
            </div>
        </div>
    </div>
<!-- end container -->
</div>
@endsection

