@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body text-center">
                <div class="mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-primary mb-3" width="64" height="64" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                        <path d="M3 7l9 6l9 -6" />
                    </svg>
                </div>

                <h2 class="h2 mb-3">{{ __('auth.verify_email_title') }}</h2>
                <p class="text-secondary mb-4">
                    {{ __('auth.verify_email_description') }}
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success" role="alert">
                        {{ __('auth.verification_link_sent') }}
                    </div>
                @endif

                <div class="d-flex gap-2 justify-content-center">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('auth.resend_verification') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link">
                            {{ __('auth.log_out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
