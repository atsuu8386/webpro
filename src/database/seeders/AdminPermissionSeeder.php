<?php

namespace Database\Seeders;

use App\Enum\PermissionAdminEnum;
use App\Enum\PermissionAdminGroupEnum;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Sync admin permissions from PermissionAdminEnum to database.
     * These are global permissions (tenant_id = null) for Super Admin only.
     */
    public function run(): void
    {
        $this->command->info('Syncing admin permissions from PermissionAdminEnum...');

        $existingAdminPermissions = Permission::where('name', 'like', 'admin.%')
            ->where('guard_name', 'admin')
            ->pluck('name')
            ->toArray();
        
        $enumPermissions = [];

        foreach (PermissionAdminEnum::cases() as $permissionEnum) {
            $enumPermissions[] = $permissionEnum->value;

            Permission::updateOrCreate(
                ['name' => $permissionEnum->value],
                [
                    'label' => $permissionEnum->label(),
                    'description' => $permissionEnum->description(),
                    'group' => $permissionEnum->group()->value,
                    'group_order' => $permissionEnum->group()->order(),
                    'order' => $permissionEnum->order(),
                    'guard_name' => 'admin',
                ]
            );
        }

        // Delete admin permissions that are not in enum
        $permissionsToDelete = array_diff($existingAdminPermissions, $enumPermissions);
        if (count($permissionsToDelete) > 0) {
            $this->command->warn('Deleting ' . count($permissionsToDelete) . ' obsolete admin permissions...');
            Permission::whereIn('name', $permissionsToDelete)
                ->where('guard_name', 'admin')
                ->delete();
        }

        $this->command->info('✓ Synced ' . count($enumPermissions) . ' admin permissions successfully!');

        // Display grouped permissions
        $this->displayGroupedPermissions();
    }

    /**
     * Display grouped admin permissions for reference
     */
    private function displayGroupedPermissions(): void
    {
        $this->command->info("\n=== Admin Permissions by Group ===\n");

        $grouped = PermissionAdminEnum::grouped();

        foreach ($grouped as $group => $permissions) {
            $groupEnum = PermissionAdminGroupEnum::from($group);
            $this->command->info("👑 {$groupEnum->label()} ({$group})");
            
            foreach ($permissions as $permission) {
                $this->command->line("   • [{$permission->value}] {$permission->label()}");
            }
            
            $this->command->newLine();
        }
    }
}
