@extends('layouts.admin')

@section('title', 'Admin Login')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Admin Login</h2>

                <form method="POST" action="{{ route('admin.login') }}" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}"
                            placeholder="your@email.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Your password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember">
                            <span class="form-check-label">Remember me</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </form>
            </div>
            <div class="hr-text">or</div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('admin.register') }}" class="btn w-100">
                            Create new account
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('admin.password.request') }}" class="btn w-100">
                            Forgot password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
