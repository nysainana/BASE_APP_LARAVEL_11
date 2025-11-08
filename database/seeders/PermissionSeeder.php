<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $existingPermissions = Permission::pluck('name')->toArray();

        $desiredPermissionKeys = static::extractPermissionKeys(Permission::PERMISSIONS_DATA);

        $permissionsToCreate = array_diff($desiredPermissionKeys, $existingPermissions);
        foreach ($permissionsToCreate as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $permissionsToDelete = array_diff($existingPermissions, $desiredPermissionKeys);
        if (!empty($permissionsToDelete)) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $permissionIdsToDelete = Permission::whereIn('name', $permissionsToDelete)->pluck('id')->toArray();
            if (!empty($permissionIdsToDelete)) {
                DB::table('role_has_permissions')->whereIn('permission_id', $permissionIdsToDelete)->delete();
            }

            Permission::whereIn('name', $permissionsToDelete)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $superAdmin = Role::firstOrCreate(['name' => RoleName::SUPER_ADMIN->value]);
        $admin = Role::firstOrCreate(['name' => RoleName::ADMIN->value]);

        $superAdmin->givePermissionTo(Permission::all());
    }

    private static function extractPermissionKeys(array $permissions): array
    {
        $keys = [];
        foreach ($permissions as $permission) {
            if (!empty($permission['children'])) {
                $keys = array_merge($keys, self::extractPermissionKeys($permission['children']));
            } else if (isset($permission['key'])) {
                $keys[] = $permission['key'];
            }
        }
        return array_unique($keys);
    }
}
