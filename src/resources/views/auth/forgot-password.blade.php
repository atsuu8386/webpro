@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ __('auth.forgot_password_title') }}</h2>
                <p class="text-secondary mb-4">
                    {{ __('auth.forgot_password_description') }}
                </p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
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

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            {{ __('auth.send_reset_link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center text-secondary mt-3">
            {{ __('auth.remember_password') }} <a href="{{ route('login') }}" tabindex="-1">{{ __('auth.sign_in') }}</a>
        </div>
    </div>
</div>
@endsection
