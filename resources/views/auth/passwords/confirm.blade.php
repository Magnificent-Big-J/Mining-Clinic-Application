@extends('layouts.authentication')
@section('content')
    <div class="login-wrapper">
        <div class="container">
            <div class="loginbox">
                <div class="login-left">
                    <img class="img-fluid" src="{{asset('invoke.png')}}" alt="Logo">
                </div>
                <div class="login-right">
                    <div class="login-right-wrap">
                        <h1>{{ __('Confirm Password') }}</h1>
                    {{ __('Please confirm your password before continuing.') }}
                    <!-- Form -->
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Password" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                        <!-- /Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
