<?php

namespace App\Enum;

/**
 * Permission groups for Tenant permissions.
 */
enum PermissionGroupEnum: string
{
    case USERS = 'users';
    case ROLES = 'roles';
    case PERMISSIONS = 'permissions';
    case ORDERS = 'orders';
    case CUSTOMERS = 'customers';

    public function label(): string
    {
        return match ($this) {
            self::USERS => 'Quản lý người dùng',
            self::ROLES => 'Quản lý vai trò',
            self::PERMISSIONS => 'Quản lý quyền',
            self::ORDERS => 'Quản lý đơn hàng',
            self::CUSTOMERS => 'Quản lý khách hàng',
        };
    }

    public function order(): int
    {
        return match ($this) {
            self::USERS => 1,
            self::ROLES => 2,
            self::PERMISSIONS => 3,
            self::ORDERS => 4,
            self::CUSTOMERS => 5,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::USERS => 'Các quyền liên quan đến quản lý người dùng',
            self::ROLES => 'Các quyền liên quan đến quản lý vai trò',
            self::PERMISSIONS => 'Các quyền liên quan đến quản lý quyền hạn',
            self::ORDERS => 'Các quyền liên quan đến quản lý đơn hàng',
            self::CUSTOMERS => 'Các quyền liên quan đến quản lý khách hàng',
        };
    }
}
