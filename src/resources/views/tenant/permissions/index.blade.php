@extends('layouts.app')

@section('title', __('permissions.permission_management'))

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ __('permissions.permission_management') }}</h2>
                <div class="text-muted mt-1">Danh sách quyền hệ thống (được quản lý qua PermissionEnum)</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="alert alert-info">
            <strong>Lưu ý:</strong> Danh sách quyền được định nghĩa trong <code>App\Enum\PermissionEnum</code> và đồng bộ tự động qua seeder. Để thêm quyền mới, hãy cập nhật enum và chạy <code>php artisan db:seed --class=PermissionSeeder</code>
        </div>

        @forelse($groupedPermissions as $groupKey => $permissions)
            @php
                $groupEnum = \App\Enum\PermissionGroupEnum::from($groupKey);
            @endphp
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">{{ $groupEnum->label() }}</h3>
                    <div class="card-subtitle">{{ $groupEnum->description() }}</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Mã quyền</th>
                                <th>Tên hiển thị</th>
                                <th>Mô tả</th>
                                <th>Guard</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td><code>{{ $permission->name }}</code></td>
                                <td><strong>{{ $permission->label }}</strong></td>
                                <td class="text-muted">{{ $permission->description }}</td>
                                <td><span class="badge badge-outline">{{ $permission->guard_name }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body text-center text-muted py-4">
                    Chưa có quyền nào. Chạy seeder để đồng bộ: <code>php artisan db:seed --class=PermissionSeeder</code>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
