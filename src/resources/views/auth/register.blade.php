@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ __('auth.register_title') }}</h2>

                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">{{ __('auth.name_label') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}"
                            placeholder="{{ __('auth.name_placeholder') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">{{ __('auth.email_label') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}"
                            placeholder="{{ __('auth.email_placeholder') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="company">{{ __('auth.company_label') }}</label>
                        <input type="text" class="form-control @error('company') is-invalid @enderror"
                            id="company" name="company" value="{{ old('company') }}"
                            placeholder="{{ __('auth.company_placeholder') }}">
                        @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">{{ __('auth.password_label') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="{{ __('auth.password_placeholder') }}" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">{{ __('auth.password_confirmation_label') }}</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation"
                            placeholder="{{ __('auth.password_confirmation_placeholder') }}" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" required>
                            <span class="form-check-label">{{ __('auth.agree_terms') }} <a href="#" tabindex="-1">{{ __('auth.terms_and_policy') }}</a>.</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('auth.create_account') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center text-secondary mt-3">
            {{ __('auth.already_have_account') }} <a href="{{ route('login') }}" tabindex="-1">{{ __('auth.sign_in') }}</a>
        </div>
    </div>
</div>
@endsection
