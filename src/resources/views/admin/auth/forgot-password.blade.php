@extends('layouts.admin')

@section('title', 'Forgot Password')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Forgot password</h2>
                <p class="text-secondary text-center mb-4">Enter your email address and we'll send you a password reset link.</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.password.email') }}" autocomplete="off">
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

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Send password reset link</button>
                    </div>
                </form>
            </div>
            <div class="hr-text">or</div>
            <div class="card-body">
                <a href="{{ route('admin.login') }}" class="btn w-100">
                    Back to login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
