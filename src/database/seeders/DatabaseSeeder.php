<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SuperAdminSeeder;
use Database\Seeders\AdminPermissionSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Tenant permissions (for regular users)
            PermissionSeeder::class,

            // Admin permissions (for super admin)
            AdminPermissionSeeder::class,

            // Role definitions
            // RoleSeeder::class,

            // Create super admin user
            SuperAdminSeeder::class,
        ]);
    }
}
