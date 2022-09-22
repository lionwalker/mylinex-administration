@extends('layouts.login')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5 pa-0">
                <div class="auth-cover-img overlay-wrap" style="background-image:url(/images/bg-2.jpg);"></div>
            </div>
            <div class="col-xl-7 pa-0">
                <div class="auth-form-wrap py-xl-0 py-50">
                    <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100">
                        <form method="POST" action="{{ route('user.login') }}" id="loginForm">
                            @csrf
                            <h1 class="display-5 mb-10">Welcome Back </h1>
                            <p class="mb-30">Sign in to your account and enjoy unlimited perks.</p>

                            <div class="form-group">
                                <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <p id="password_error" class="error"></p>
                            </div>
                            <button class="btn btn-primary-blue btn-block mb-5" type="submit">Login</button>
                            @if (Route::has('password.request'))
                                <a class="text-center text-primary-blue" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
