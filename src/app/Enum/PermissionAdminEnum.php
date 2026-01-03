<?php

namespace App\Enum;

/**
 * Permissions for Super Admin only.
 * These permissions are only available on admin.orderflow.test domain.
 */
enum PermissionAdminEnum: string
{
    /* ===== Tenants Management (Super Admin Only) ===== */
    case TENANTS_VIEW   = 'admin.tenants.view';
    case TENANTS_CREATE = 'admin.tenants.create';
    case TENANTS_UPDATE = 'admin.tenants.update';
    case TENANTS_DELETE = 'admin.tenants.delete';

    /* ================= METADATA ================= */

    /**
     * Get the permission group enum
     */
    public function group(): PermissionAdminGroupEnum
    {
        return match ($this) {
            self::TENANTS_VIEW,
            self::TENANTS_CREATE,
            self::TENANTS_UPDATE,
            self::TENANTS_DELETE => PermissionAdminGroupEnum::TENANTS,
        };
    }

    /**
     * Get the order within the group
     */
    public function order(): int
    {
        return match ($this) {
            self::TENANTS_VIEW => 1,
            self::TENANTS_CREATE => 2,
            self::TENANTS_UPDATE => 3,
            self::TENANTS_DELETE => 4,
        };
    }

    /**
     * Get the permission label
     */
    public function label(): string
    {
        return match ($this) {
            self::TENANTS_VIEW => 'Xem danh sách',
            self::TENANTS_CREATE => 'Tạo mới',
            self::TENANTS_UPDATE => 'Cập nhật',
            self::TENANTS_DELETE => 'Xoá',
        };
    }

    /**
     * Get the permission description
     */
    public function description(): string
    {
        return match ($this) {
            self::TENANTS_VIEW => 'Xem danh sách tenant',
            self::TENANTS_CREATE => 'Tạo tenant mới',
            self::TENANTS_UPDATE => 'Cập nhật thông tin tenant',
            self::TENANTS_DELETE => 'Xoá tenant',
        };
    }

    /**
     * Get all admin permissions grouped by group
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
            return PermissionAdminGroupEnum::from($a)->order() <=> PermissionAdminGroupEnum::from($b)->order();
        });

        return $grouped;
    }

    /**
     * Check if user is super admin (has any admin permission)
     */
    public static function isSuperAdmin($user): bool
    {
        if (!$user) {
            return false;
        }
        $p = self::cases();
        foreach (self::cases() as $permission) {
            if ($user->can($permission->value)) {
                return true;
            }
        }

        return false;
    }
}
