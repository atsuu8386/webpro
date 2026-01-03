@extends('layouts.app')

@section('title', __('roles.role_management'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('roles.role_management') }}</h2>
                <div class="text-muted mt-1">{{ __('roles.manage_all_roles') }}</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    {{ __('roles.create_new_role') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>{{ session('success') }}</div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>{{ __('roles.name') }}</th>
                            <th>{{ __('roles.permissions_count') }}</th>
                            <th>{{ __('roles.users_count') }}</th>
                            <th>{{ __('roles.created_at') }}</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>
                                <strong>{{ $role->name }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-outline text-blue">
                                    {{ $role->permissions_count }} {{ __('roles.permissions') }}
                                </span>
                            </td>
                            <td>
                                {{ $role->users_count }} {{ __('users.users') }}
                            </td>
                            <td>{{ $role->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-ghost-primary">
                                        {{ __('roles.edit') }}
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('roles.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost-danger">
                                            {{ __('roles.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                {{ __('roles.no_roles_found') }} <a href="{{ route('roles.create') }}">{{ __('roles.create_first_role') }}</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($roles->hasPages())
            <div class="card-footer d-flex align-items-center">
                {{ $roles->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
