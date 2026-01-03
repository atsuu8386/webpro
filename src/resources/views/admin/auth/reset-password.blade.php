@extends('layouts.admin')

@section('title', 'Reset Password')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Reset password</h2>

                <form method="POST" action="{{ route('admin.password.update') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ $email ?? old('email') }}"
                            placeholder="your@email.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Your new password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control"
                            id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm your new password" required>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Reset password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
