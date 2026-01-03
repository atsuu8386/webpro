<?php

namespace Database\Seeders;

use App\Enum\PermissionAdminEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Seeder for creating Super Admin tenant, domain, and user with admin permissions.
 *
 * This seeder creates:
 * - Admin tenant for admin.orderflow.test domain
 * - Super Admin user with all admin permissions
 * - Owner role in admin tenant
 *
 * Run: php artisan db:seed --class=SuperAdminSeeder
 */
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating Super Admin tenant, domain, and user...');

        DB::beginTransaction();

        try {
            // Get credentials from environment or use defaults
            $superAdminEmail = env('SUPER_ADMIN_EMAIL', 'admin@getorders.dev');
            $superAdminPassword = env('SUPER_ADMIN_PASSWORD', 'password');
            $superAdminName = env('SUPER_ADMIN_NAME', 'Super Admin');
            $adminDomain = 'admin.getorders.dev';

            // 1. Create Admin Tenant
            $adminTenantId = Str::orderedUuid()->toString();
            $tenant = Tenant::firstOrCreate(
                ['id' => $adminTenantId],
                [
                    'name' => 'Admin System',
                    'email' => $superAdminEmail,
                    'subdomain' => 'admin',
                    'package_id' => null, // No package limitation for admin
                    'package_started_at' => null,
                    'package_expires_at' => null,
                ]
            );

            $this->command->info("✓ Admin tenant created: {$tenant->id}");

            // 2. Create Domain for Admin Tenant
            $domain = $tenant->domains()->firstOrCreate(
                ['domain' => $adminDomain]
            );

            $this->command->info("✓ Admin domain created: {$adminDomain}");

            // 3. Initialize tenant context to create user
            tenancy()->initialize($tenant);

            // 4. Create Super Admin user in admin tenant
            $superAdmin = User::updateOrCreate(
                ['email' => $superAdminEmail],
                [
                    'name' => $superAdminName,
                    'password' => Hash::make($superAdminPassword),
                    'email_verified_at' => now(),
                    'tenant_id' => $tenant->id,
                ]
            );

            $this->command->info("✓ Super Admin user created in admin tenant");

            // 5. Create Super Admin role in admin tenant context
            $superAdminRole = Role::firstOrCreate(
                ['name' => 'Super Admin', 'tenant_id' => $tenant->id],
                ['guard_name' => 'admin']
            );

            $this->command->info("✓ Super Admin role created");

            // 6. Get all admin permissions
            $adminPermissions = Permission::where('guard_name', 'admin')
                ->where('name', 'like', 'admin.%')
                ->get();

            if ($adminPermissions->isEmpty()) {
                $this->command->warn('⚠ No admin permissions found. Please run AdminPermissionSeeder first.');
            } else {
                // Assign all admin permissions to Super Admin role (role_has_permissions table)
                $superAdminRole->syncPermissions($adminPermissions);
                $this->command->info("✓ {$adminPermissions->count()} admin permissions assigned to Super Admin role");

                // Assign all admin permissions directly to user
                $superAdmin->syncPermissions($adminPermissions);
                $this->command->info("✓ {$adminPermissions->count()} admin permissions assigned to user");
            }

            // 7. Assign Super Admin role to user
            if (!$superAdmin->hasRole('Super Admin')) {
                $superAdmin->assignRole($superAdminRole);
                $this->command->info("✓ Super Admin role assigned to user");
            }

            // End tenant context
            tenancy()->end();

            DB::commit();

            // Display success info
            $this->command->newLine();
            $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->command->info('Super Admin Setup Complete!');
            $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->command->info('Tenant ID: ' . $tenant->id);
            $this->command->info('Domain: https://' . $adminDomain);
            $this->command->info('Email: ' . $superAdminEmail);
            $this->command->info('Password: ' . $superAdminPassword);
            $this->command->info('Permissions: ' . $adminPermissions->count() . ' admin permissions');
            $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->command->newLine();

            // Display assigned permissions
            if (!$adminPermissions->isEmpty()) {
                $this->displayAssignedPermissions($superAdmin);
            }

            $this->command->warn('⚠ Please change the password after first login!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error creating Super Admin: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Display assigned permissions for verification
     */
    private function displayAssignedPermissions(User $user): void
    {
        $this->command->info('=== Assigned Admin Permissions ===');
        $this->command->newLine();

        $grouped = PermissionAdminEnum::grouped();

        foreach ($grouped as $group => $permissions) {
            $groupEnum = \App\Enum\PermissionAdminGroupEnum::from($group);
            $this->command->info("👑 {$groupEnum->label()}");

            foreach ($permissions as $permission) {
                $hasPermission = $user->hasPermissionTo($permission->value, 'admin');
                $icon = $hasPermission ? '✓' : '✗';
                $this->command->line("   {$icon} {$permission->value}");
            }

            $this->command->newLine();
        }
    }
}
