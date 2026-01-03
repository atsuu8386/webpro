<?php

namespace Database\Seeders;

use App\Enum\PermissionEnum;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Sync permissions from PermissionEnum to database.
     */
    public function run(): void
    {
        $this->command->info('Syncing permissions from PermissionEnum...');

        $existingPermissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();
        $enumPermissions = [];

        foreach (PermissionEnum::cases() as $permissionEnum) {
            $enumPermissions[] = $permissionEnum->value;

            Permission::updateOrCreate(
                ['name' => $permissionEnum->value],
                [
                    'label' => $permissionEnum->label(),
                    'description' => $permissionEnum->description(),
                    'group' => $permissionEnum->group()->value,
                    'group_order' => $permissionEnum->group()->order(),
                    'order' => $permissionEnum->order(),
                    'guard_name' => 'web',
                ]
            );
        }

        // Delete permissions that are not in enum
        $permissionsToDelete = array_diff($existingPermissions, $enumPermissions);
        if (count($permissionsToDelete) > 0) {
            $this->command->warn('Deleting ' . count($permissionsToDelete) . ' obsolete permissions...');
            Permission::whereIn('name', $permissionsToDelete)->delete();
        }

        $this->command->info('✓ Synced ' . count($enumPermissions) . ' permissions successfully!');

        // Display grouped permissions
        $this->displayGroupedPermissions();
    }

    /**
     * Display grouped permissions for reference
     */
    private function displayGroupedPermissions(): void
    {
        $this->command->info("\n=== Permissions by Group ===\n");

        $grouped = PermissionEnum::grouped();

        foreach ($grouped as $group => $permissions) {
            $groupEnum = \App\Enum\PermissionGroupEnum::from($group);
            $this->command->info("📁 {$groupEnum->label()} ({$group})");
            
            foreach ($permissions as $permission) {
                $this->command->line("   • [{$permission->value}] {$permission->label()}");
            }
            
            $this->command->newLine();
        }
    }
}
