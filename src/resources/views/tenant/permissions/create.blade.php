@extends('layouts.app')

@section('title', __('permissions.create_permission'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('permissions.create_permission') }}</h2>
                <div class="text-muted mt-1">{{ __('permissions.add_new_permission') }}</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                    {{ __('permissions.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form action="{{ route('permissions.store') }}" method="POST" class="card">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">{{ __('permissions.permission_name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" placeholder="{{ __('permissions.enter_permission_name') }}" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">{{ __('permissions.permission_name_hint') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">{{ __('permissions.permission_code') }}</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                   name="code" placeholder="create_posts" value="{{ old('code') }}" required>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">{{ __('permissions.permission_code_hint') }}</small>
                        </div>
                        <div class="alert alert-info">
                            <strong>{{ __('permissions.examples') }}:</strong>
                            <ul class="mb-0">
                                <li>Name: "Create Posts" → Code: "create_posts"</li>
                                <li>Name: "Edit Users" → Code: "edit_users"</li>
                                <li>Name: "Delete Comments" → Code: "delete_comments"</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('permissions.index') }}" class="btn btn-link">{{ __('common.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('permissions.create_new_permission') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
