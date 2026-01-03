@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('profile.title') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <!-- Profile Information -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('profile.profile_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update', absolute: false) }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label class="form-label required" for="profile_name">{{ __('common.name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="profile_name" name="name"
                                       value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label required" for="profile_email">{{ __('common.email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="profile_email" name="email"
                                       value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                    <div class="form-hint text-warning mt-2">
                                        {{ __('profile.email_unverified') }}
                                        <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0">{{ __('profile.resend_verification') }}</button>
                                        </form>
                                    </div>

                                    @if (session('status') === 'verification-link-sent')
                                        <div class="text-success mt-2">{{ __('profile.verification_sent') }}</div>
                                    @endif
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('profile.save_changes') }}</button>
                                @if (session('status') === 'profile-updated')
                                    <span class="text-success align-self-center">{{ __('profile.saved_successfully') }}</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('profile.update_password') }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-secondary mb-3">{{ __('profile.update_password_description') }}</p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label required" for="current_password">{{ __('profile.current_password') }}</label>
                                <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                       id="current_password" name="current_password" required>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label required" for="password">{{ __('profile.new_password') }}</label>
                                <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label required" for="password_confirmation">{{ __('common.confirm_password') }}</label>
                                <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                       id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">{{ __('profile.update_password_button') }}</button>
                                @if (session('status') === 'password-updated')
                                    <span class="text-success align-self-center">{{ __('profile.password_updated') }}</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('profile.delete_account') }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-secondary mb-3">
                            {{ __('profile.delete_account_description') }}
                        </p>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            {{ __('profile.delete_account_button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal modal-blur fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">{{ __('profile.delete_account_confirm_title') }}</div>
                <div class="text-secondary">{{ __('profile.delete_account_confirm_description') }}</div>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-3">
                        <label class="form-label" for="delete_password">{{ __('common.password') }}</label>
                        <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               id="delete_password" name="password"
                               placeholder="{{ __('profile.enter_password') }}" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn" data-bs-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('profile.delete_account_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($errors->userDeletion->any())
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
            modal.show();
        });
    </script>
    @endpush
@endif
@endsection
