@extends('layouts.app')

@section('title', __('users.user_details'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('users.user_details') }}</h2>
                <div class="text-muted mt-1">{{ $user->name }}</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        {{ __('users.back_to_list') }}
                    </a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                        {{ __('users.edit_user_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('users.basic_information') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{ __('users.name') }}</div>
                                <div class="datagrid-content">{{ $user->name }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{ __('users.email') }}</div>
                                <div class="datagrid-content">{{ $user->email }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{ __('users.created_at') }}</div>
                                <div class="datagrid-content">{{ $user->created_at->format('F d, Y H:i') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">{{ __('users.updated_at') }}</div>
                                <div class="datagrid-content">{{ $user->updated_at->format('F d, Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('users.user_roles') }}</h3>
                    </div>
                    <div class="card-body">
                        @if($user->roles->isNotEmpty())
                        <div class="list-group list-group-flush">
                            @foreach($user->roles as $role)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <strong>{{ $role->name }}</strong>
                                        <div class="text-muted small">
                                            {{ $role->permissions->count() }} {{ __('users.permissions') }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge badge-outline text-blue">
                                            {{ __('roles.role') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-muted text-center py-4">
                            {{ __('users.no_roles_assigned') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('users.user_permissions') }}</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $allPermissions = $user->roles->flatMap->permissions->unique('id');
                        @endphp
                        @if($allPermissions->isNotEmpty())
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($allPermissions as $permission)
                            <span class="badge badge-outline">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                        @else
                        <div class="text-muted text-center py-4">
                            {{ __('users.no_permissions') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
