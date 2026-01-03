<?php

namespace Database\Seeders;

use App\Enum\PermissionAdminEnum;
use App\Enum\PermissionEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Seeder for creating default roles with permissions.
 * 
 * This seeder creates:
 * - Super Admin role: For admin tenant with all admin permissions
 * - Owner role: Template role for tenant owners with all tenant permissions
 * 
 * Run: php artisan db:seed --class=RoleSeeder
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating default roles...');

        // 1. Create Super Admin Role with Admin Permissions
        $this->createSuperAdminRole();

        // 2. Create Owner Role Template with Tenant Permissions
        // $this->createOwnerRoleTemplate();

        $this->command->info('✓ All roles created successfully!');
    }

    /**
     * Create Super Admin role with all admin permissions.
     * This role is for admin tenant only (admin.orderflow.test).
     */
    private function createSuperAdminRole(): void
    {
        $this->command->info('Creating Super Admin role...');

        // Create Super Admin role (global or will be assigned to admin tenant)
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'admin'],
            ['tenant_id' => null]
        );

        // Get all admin permissions
        $adminPermissions = Permission::where('guard_name', 'admin')
            ->where('name', 'like', 'admin.%')
            ->get();

        if ($adminPermissions->isEmpty()) {
            $this->command->warn('⚠ No admin permissions found. Please run AdminPermissionSeeder first.');
            return;
        }

        // Sync all admin permissions to Super Admin role
        $superAdminRole->syncPermissions($adminPermissions);

        $this->command->info("✓ Super Admin role created with {$adminPermissions->count()} permissions");
        $this->displayRolePermissions($superAdminRole, PermissionAdminEnum::grouped());
    }

    /**
     * Create Owner role template with all tenant permissions.
     * This role template will be used when creating new tenants.
     */
    private function createOwnerRoleTemplate(): void
    {
        $this->command->info('Creating Owner role template...');

        // Create Owner role template (global template)
        $ownerRole = Role::firstOrCreate(
            ['name' => 'Owner', 'guard_name' => 'web'],
            ['tenant_id' => null]
        );

        // Get all tenant permissions
        $tenantPermissions = Permission::where('guard_name', 'web')
            ->whereNotLike('name', 'admin.%')
            ->get();

        if ($tenantPermissions->isEmpty()) {
            $this->command->warn('⚠ No tenant permissions found. Please run PermissionSeeder first.');
            return;
        }

        // Sync all tenant permissions to Owner role
        $ownerRole->syncPermissions($tenantPermissions);

        $this->command->info("✓ Owner role template created with {$tenantPermissions->count()} permissions");
        $this->displayRolePermissions($ownerRole, PermissionEnum::grouped());
    }

    /**
     * Display role permissions grouped by group
     */
    private function displayRolePermissions(Role $role, array $grouped): void
    {
        $this->command->newLine();
        $this->command->info("=== {$role->name} Role Permissions ===");
        $this->command->newLine();

        foreach ($grouped as $group => $permissions) {
            // Get group label
            if ($role->guard_name === 'admin') {
                $groupEnum = \App\Enum\PermissionAdminGroupEnum::tryFrom($group);
                $icon = '👑';
            } else {
                $groupEnum = \App\Enum\PermissionGroupEnum::tryFrom($group);
                $icon = '📁';
            }

            if ($groupEnum) {
                $this->command->info("{$icon} {$groupEnum->label()}");
                
                foreach ($permissions as $permission) {
                    $this->command->line("   • {$permission->value}");
                }
                
                $this->command->newLine();
            }
        }
    }
}
