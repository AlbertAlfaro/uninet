@extends('layouts.master-without-nav')
@section('title')
Reset Password
@endsection
@section('content')
<div class="home-btn d-none d-sm-block">
    <a href="{{url('index')}}" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
</div>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{url('index')}}" class="mb-5 d-block auth-logo">
                        <img src="{{ URL::asset('assets/images/logo-dark.png')}}" alt="" height="22" class="logo logo-dark">
                        <img src="{{ URL::asset('assets/images/logo-light.png')}}" alt="" height="22" class="logo logo-light">
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">{{ __('Resetear contraseña') }}</h5>
                        <p class="text-muted">Resetear contraseña</p>
                    </div>
                    <div class="p-2 mt-4">
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">{{ __('Correo') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Enter email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-3 text-right">
                                <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">{{ __('Enviar link para resetear') }}</button>
                            </div>
                            <div class="mt-4 text-center">
                                <p class="mb-0">Recuerdas tu credenciales ? <a href="{{url('login')}}" class="font-weight-medium text-primary"> Iniciar sesion </a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center">
                <p>© 2021 UNINEX.</p>
            </div>
        </div>
    </div>
</div>
<!-- end container -->
</div>
@endsection

