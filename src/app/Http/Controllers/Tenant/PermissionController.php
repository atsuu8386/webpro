<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions grouped by group.
     * Permissions are now global and synced from PermissionEnum.
     * No CRUD operations - managed via enum and seeder.
     */
    public function index(): View
    {
        // Get permissions grouped by group, ordered
        $groupedPermissions = Permission::findByGuardGrouped('web');
        return view('tenant.permissions.index', compact('groupedPermissions'));
    }
}
