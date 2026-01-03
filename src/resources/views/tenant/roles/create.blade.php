@extends('layouts.app')

@section('title', __('roles.create_role'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('roles.create_role') }}</h2>
                <div class="text-muted mt-1">{{ __('roles.add_new_role') }}</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    {{ __('roles.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form action="{{ route('roles.store') }}" method="POST" class="card">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">{{ __('roles.role_name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" placeholder="{{ __('roles.enter_role_name') }}" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-hint">{{ __('roles.role_name_hint') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('roles.assign_permissions') }}</label>
                            <div class="card">
                                <div class="card-body">
                                    @if($permissions->isEmpty())
                                        <div class="text-muted">{{ __('roles.no_permissions_assigned') }}</div>
                                    @else
                                        <div class="row">
                                            @foreach($permissions as $permission)
                                            <div class="col-md-4 mb-2">
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                    <span class="form-check-label">{{ $permission->name }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <small class="form-hint">{{ __('roles.permissions_hint') }}</small>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('roles.index') }}" class="btn btn-link">{{ __('common.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('roles.create_new_role') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
