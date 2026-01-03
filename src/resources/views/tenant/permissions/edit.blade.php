@extends('layouts.app')

@section('title', __('permissions.edit_permission'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('permissions.edit_permission') }}: {{ $permission->name }}</h2>
                <div class="text-muted mt-1">{{ __('permissions.update_permission_info') }}</div>
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
                <form action="{{ route('permissions.update', $permission) }}" method="POST" class="card">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">{{ __('permissions.permission_name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name', $permission->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">{{ __('permissions.permission_code') }}</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                   name="code" value="{{ old('code', $permission->code) }}" required>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">{{ __('permissions.permission_code_hint') }}</small>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('permissions.index') }}" class="btn btn-link">{{ __('common.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('permissions.update_permission_btn') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
