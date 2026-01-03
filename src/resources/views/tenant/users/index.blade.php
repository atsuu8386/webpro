@extends('layouts.app')

@section('title', __('users.user_management'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('users.user_management') }}</h2>
                <div class="text-muted mt-1">{{ __('users.manage_all_users') }}</div>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    {{ __('users.create_new_user') }}
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
                            <th>{{ __('users.name') }}</th>
                            <th>{{ __('users.email') }}</th>
                            <th>{{ __('users.roles') }}</th>
                            <th>{{ __('users.created_at') }}</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-sm me-2">{{ substr($user->name, 0, 2) }}</span>
                                    <div>{{ $user->name }}</div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-outline text-blue me-1">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">{{ __('users.no_roles_assigned') }}</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-ghost-secondary">
                                        {{ __('users.view') }}
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-ghost-primary">
                                        {{ __('users.edit') }}
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('users.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost-danger">
                                            {{ __('users.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                {{ __('users.no_users_found') }} <a href="{{ route('users.create') }}">{{ __('users.create_first_user') }}</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="card-footer d-flex align-items-center">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
