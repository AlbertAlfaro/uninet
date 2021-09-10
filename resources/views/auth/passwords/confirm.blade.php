@extends('layouts.master-without-nav')
@section('title')
Confirm Password
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
                        <h5 class="text-primary">{{ __('Confirm Password') }}</h5>
                        <p class="text-muted">{{ __('Please confirm your password before continuing.') }}</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group">
                                <div class="float-right">
                                    @if (Route::has('password.request'))
                                        <a class="text-muted" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mt-3 text-right">
                                <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">{{ __('Confirm Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <div class="mt-5 text-center">
        <p>© 2020 Minible. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
    </div>
</div>
</div>
</div>
<!-- end container -->
</div>
@endsection