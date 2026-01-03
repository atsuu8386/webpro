@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <!-- BEGIN NAVBAR LOGO -->
            <a href="." aria-label="Tabler" class="navbar-brand navbar-brand-autodark">
                <svg
                    width="65"
                    height="65"
                    viewBox="0 0 240 240"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <!-- Background -->
                    <rect width="240" height="240" rx="32" fill="#2563EB" />

                    <!-- Box (Order) -->
                    <rect x="60" y="70" width="120" height="100" rx="12" fill="#FFFFFF" />
                    <path
                        d="M60 95H180"
                        stroke="#2563EB"
                        stroke-width="4" />

                    <!-- Checklist lines -->
                    <rect x="78" y="112" width="60" height="8" rx="4" fill="#2563EB" />
                    <rect x="78" y="132" width="80" height="8" rx="4" fill="#2563EB" />

                    <!-- Check icon -->
                    <circle cx="160" cy="124" r="14" fill="#22C55E" />
                    <path
                        d="M154 124L159 129L167 118"
                        stroke="#FFFFFF"
                        stroke-width="3"
                        stroke-linecap="round"
                        stroke-linejoin="round" />

                    <!-- Arrow (Process / Flow) -->
                    <path
                        d="M120 40V60M120 40L112 48M120 40L128 48"
                        stroke="#FFFFFF"
                        stroke-width="4"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span class="orderflow-text">Get<span>Orders</span></span>
            </a>
            <!-- END NAVBAR LOGO -->
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ __('auth.login_title') }}</h2>

                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login', absolute: false) }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">{{ __('auth.email_label') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}"
                            placeholder="{{ __('auth.email_placeholder') }}" required autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="password">
                            {{ __('auth.password_label') }}
                            @if (Route::has('password.request'))
                            <span class="form-label-description">
                                <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
                            </span>
                            @endif
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="{{ __('auth.password_placeholder') }}" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                            <span class="form-check-label">{{ __('auth.remember_me') }}</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('auth.sign_in') }}</button>
                    </div>
                </form>
            </div>
        </div>

        @if (Route::has('register'))
        <div class="text-center text-secondary mt-3">
            {{ __('auth.no_account') }} <a href="{{ route('register') }}" tabindex="-1">{{ __('auth.sign_up') }}</a>
        </div>
        @endif
    </div>
</div>
@endsection