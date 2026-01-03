<?php

namespace App\Enum;

/**
 * Permissions for Tenant users.
 * These permissions are available on tenant subdomains (e.g., test1.orderflow.test).
 */
enum PermissionEnum: string
{
    /* ===== Users Management ===== */
    case USERS_VIEW   = 'users.view';
    case USERS_CREATE = 'users.create';
    case USERS_UPDATE = 'users.update';
    case USERS_DELETE = 'users.delete';

    /* ===== Roles Management ===== */
    case ROLES_VIEW   = 'roles.view';
    case ROLES_CREATE = 'roles.create';
    case ROLES_UPDATE = 'roles.update';
    case ROLES_DELETE = 'roles.delete';

    /* ===== Permissions Management ===== */
    case PERMISSIONS_VIEW   = 'permissions.view';
    case PERMISSIONS_CREATE = 'permissions.create';
    case PERMISSIONS_UPDATE = 'permissions.update';
    case PERMISSIONS_DELETE = 'permissions.delete';

    /* ===== Orders Management ===== */
    case ORDERS_VIEW   = 'orders.view';
    case ORDERS_CREATE = 'orders.create';
    case ORDERS_UPDATE = 'orders.update';
    case ORDERS_DELETE = 'orders.delete';

    /* ===== Customers Management ===== */
    case CUSTOMERS_VIEW   = 'customers.view';
    case CUSTOMERS_CREATE = 'customers.create';
    case CUSTOMERS_UPDATE = 'customers.update';
    case CUSTOMERS_DELETE = 'customers.delete';

    /* ================= METADATA ================= */

    /**
     * Get the permission group enum
     */
    public function group(): PermissionGroupEnum
    {
        return match ($this) {
            self::USERS_VIEW,
            self::USERS_CREATE,
            self::USERS_UPDATE,
            self::USERS_DELETE => PermissionGroupEnum::USERS,

            self::ROLES_VIEW,
            self::ROLES_CREATE,
            self::ROLES_UPDATE,
            self::ROLES_DELETE => PermissionGroupEnum::ROLES,

            self::PERMISSIONS_VIEW,
            self::PERMISSIONS_CREATE,
            self::PERMISSIONS_UPDATE,
            self::PERMISSIONS_DELETE => PermissionGroupEnum::PERMISSIONS,

            self::ORDERS_VIEW,
            self::ORDERS_CREATE,
            self::ORDERS_UPDATE,
            self::ORDERS_DELETE => PermissionGroupEnum::ORDERS,

            self::CUSTOMERS_VIEW,
            self::CUSTOMERS_CREATE,
            self::CUSTOMERS_UPDATE,
            self::CUSTOMERS_DELETE => PermissionGroupEnum::CUSTOMERS,
        };
    }

    /**
     * Get the order within the group
     */
    public function order(): int
    {
        return match ($this) {
            self::USERS_VIEW,
            self::ROLES_VIEW,
            self::PERMISSIONS_VIEW,
            self::ORDERS_VIEW,
            self::CUSTOMERS_VIEW => 1,

            self::USERS_CREATE,
            self::ROLES_CREATE,
            self::PERMISSIONS_CREATE,
            self::ORDERS_CREATE,
            self::CUSTOMERS_CREATE => 2,

            self::USERS_UPDATE,
            self::ROLES_UPDATE,
            self::PERMISSIONS_UPDATE,
            self::ORDERS_UPDATE,
            self::CUSTOMERS_UPDATE => 3,

            self::USERS_DELETE,
            self::ROLES_DELETE,
            self::PERMISSIONS_DELETE,
            self::ORDERS_DELETE,
            self::CUSTOMERS_DELETE => 4,
        };
    }

    /**
     * Get the permission label
     */
    public function label(): string
    {
        return match ($this) {
            self::USERS_VIEW,
            self::ROLES_VIEW,
            self::PERMISSIONS_VIEW,
            self::ORDERS_VIEW,
            self::CUSTOMERS_VIEW => 'Xem danh sách',

            self::USERS_CREATE,
            self::ROLES_CREATE,
            self::PERMISSIONS_CREATE,
            self::ORDERS_CREATE,
            self::CUSTOMERS_CREATE => 'Tạo mới',

            self::USERS_UPDATE,
            self::ROLES_UPDATE,
            self::PERMISSIONS_UPDATE,
            self::ORDERS_UPDATE,
            self::CUSTOMERS_UPDATE => 'Cập nhật',

            self::USERS_DELETE,
            self::ROLES_DELETE,
            self::PERMISSIONS_DELETE,
            self::ORDERS_DELETE,
            self::CUSTOMERS_DELETE => 'Xoá',
        };
    }

    /**
     * Get the permission description
     */
    public function description(): string
    {
        return match ($this) {
            self::USERS_VIEW => 'Xem danh sách người dùng',
            self::USERS_CREATE => 'Tạo người dùng mới',
            self::USERS_UPDATE => 'Cập nhật thông tin người dùng',
            self::USERS_DELETE => 'Xoá người dùng',

            self::ROLES_VIEW => 'Xem danh sách vai trò',
            self::ROLES_CREATE => 'Tạo vai trò mới',
            self::ROLES_UPDATE => 'Cập nhật vai trò',
            self::ROLES_DELETE => 'Xoá vai trò',

            self::PERMISSIONS_VIEW => 'Xem danh sách quyền hạn',
            self::PERMISSIONS_CREATE => 'Tạo quyền hạn mới',
            self::PERMISSIONS_UPDATE => 'Cập nhật quyền hạn',
            self::PERMISSIONS_DELETE => 'Xoá quyền hạn',

            self::ORDERS_VIEW => 'Xem danh sách đơn hàng',
            self::ORDERS_CREATE => 'Tạo đơn hàng mới',
            self::ORDERS_UPDATE => 'Cập nhật đơn hàng',
            self::ORDERS_DELETE => 'Xoá đơn hàng',

            self::CUSTOMERS_VIEW => 'Xem danh sách khách hàng',
            self::CUSTOMERS_CREATE => 'Tạo khách hàng mới',
            self::CUSTOMERS_UPDATE => 'Cập nhật thông tin khách hàng',
            self::CUSTOMERS_DELETE => 'Xoá khách hàng',
        };
    }

    /**
     * Get all permissions grouped by group
     */
    public static function grouped(): array
    {
        $grouped = [];
        foreach (self::cases() as $permission) {
            $group = $permission->group()->value;
            $grouped[$group][] = $permission;
        }

        // Sort by group order
        uksort($grouped, function ($a, $b) {
            return PermissionGroupEnum::from($a)->order() <=> PermissionGroupEnum::from($b)->order();
        });

        return $grouped;
    }
}
