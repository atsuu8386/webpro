<?php

namespace App\Models;

use App\Enum\PermissionEnum;
use App\Enum\PermissionGroupEnum;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'label',
        'description',
        'group',
        'group_order',
        'order',
        'guard_name',
    ];

    /**
     * Get the permission group enum
     */
    public function getGroupEnum(): ?PermissionGroupEnum
    {
        return PermissionGroupEnum::tryFrom($this->group);
    }

    /**
     * Get the permission enum
     */
    public function getPermissionEnum(): ?PermissionEnum
    {
        return PermissionEnum::tryFrom($this->name);
    }

    /**
     * Scope to filter by group
     */
    public function scopeByGroup($query, string|PermissionGroupEnum $group)
    {
        $groupValue = $group instanceof PermissionGroupEnum ? $group->value : $group;
        return $query->where('group', $groupValue);
    }

    /**
     * Scope to order by group and order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('group_order')->orderBy('order');
    }

    /**
     * Get permissions grouped by group
     */
    public static function grouped(): \Illuminate\Support\Collection
    {
        return static::ordered()->get()->groupBy('group');
    }

    public static function findByGuardGrouped($guardName): \Illuminate\Support\Collection
    {
        return static::where('guard_name', $guardName)->ordered()->get()->groupBy('group');
    }
}
