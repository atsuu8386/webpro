@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ __('auth.confirm_password_title') }}</h2>
                <p class="text-secondary mb-4">
                    {{ __('auth.confirm_password_description') }}
                </p>

                <form method="POST" action="{{ route('password.confirm') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="password">{{ __('auth.password_label') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="{{ __('auth.password_placeholder') }}" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">{{ __('auth.confirm_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
