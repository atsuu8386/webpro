<?php

namespace App\Enum;

/**
 * Permission groups for Super Admin permissions.
 */
enum PermissionAdminGroupEnum: string
{
    case TENANTS = 'admin.tenants';

    public function label(): string
    {
        return match ($this) {
            self::TENANTS => 'Quản lý Tenants',
        };
    }

    public function order(): int
    {
        return match ($this) {
            self::TENANTS => 1,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::TENANTS => 'Các quyền quản lý tenants hệ thống',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::TENANTS => 'ti ti-building-store',
        };
    }
}
