@extends('layouts.app')

@section('title', __('roles.edit_role'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('roles.edit_role') }}: {{ $role->name }}</h2>
                <div class="text-muted mt-1">{{ __('roles.update_role_info') }}</div>
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
                <form action="{{ route('roles.update', $role) }}" method="POST" class="card">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">{{ __('roles.role_name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $role->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('roles.assign_permissions') }}</label>
                            <div class="card">
                                <div class="card-body">
                                    @php
                                    $groups = collect(\App\Enum\PermissionGroupEnum::cases())->sortBy(fn($g) => $g->order());
                                    @endphp

                                    @if($permissions->isEmpty())
                                    <div class="text-muted">{{ __('roles.no_permissions_assigned') }}</div>
                                    @else
                                    <div class="accordion accordion-tabs" id="accordion-tabs">
                                        @foreach($groups as $group)
                                        @php
                                        $groupPermissions = $permissions->filter(fn($p) => ($p->guard_name === 'web') && ($p->group === $group->value));
                                        @endphp

                                        @if($groupPermissions->isEmpty())
                                        @continue
                                        @endif
                                        <div class="accordion-item">
                                            <div class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $group->value }}-tabs" aria-expanded="false">
                                                    {{ $group->label() }}
                                                    <div class="accordion-button-toggle">
                                                        <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-down -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                            <path d="M6 9l6 6l6 -6"></path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </div>
                                            <div id="collapse-{{ $group->value }}-tabs" class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        @foreach($groupPermissions as $permission)
                                                        <div class="col-md-4 mb-2">
                                                            <label class="form-selectgroup-item flex-fill">
                                                                <input class="form-selectgroup-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                                <div class="form-selectgroup-label d-flex align-items-center p-2">
                                                                    <div class="me-3">
                                                                        <span class="form-selectgroup-check"></span>
                                                                    </div>
                                                                    <div class="form-selectgroup-label-content d-flex flex-column align-items-start">
                                                                        <div class="font-weight-medium">{{ $permission->label }}</div>
                                                                        <div class="text-secondary">{{ $permission->description }}</div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('roles.index') }}" class="btn btn-link">{{ __('common.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('roles.update_role_btn') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection