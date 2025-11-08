<?php

namespace App\Http\Controllers;

use App\Enums\RoleName;
use App\Models\Permission;
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $filters = Validator::make($request->all(), [
            "search" => "sometimes|string",
        ])->safe()->all();

        $search = $filters["search"] ?? null;

        $roles = Role::query()->with('permissions')
            ->when($search, fn($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->when(!$user->hasRole(RoleName::SUPER_ADMIN->value), fn($query) => $query->whereNotIn('name', [RoleName::SUPER_ADMIN->value, RoleName::ADMIN->value]));

        return Inertia::render('RoleUser/Index', [
            'data' => $roles->paginate(config('app.pagination.per_page')),
            'extra_data' => [
                'permissions' => Permission::PERMISSIONS_DATA,
                'protected_roles' => [RoleName::ADMIN->value, RoleName::SUPER_ADMIN->value]
            ],
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $permissions = array_unique(array_merge($request->permissions ?? [], ['dashboard']));
        DB::beginTransaction();
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($permissions);
        DB::commit();

        return back()->with('message.success', 'Enregistrement effectué');
    }

    public function update(Request $request, Role $role_user)
    {
        if ($role_user->name === RoleName::SUPER_ADMIN->value) {
            return back()->with('message.error', 'Impossible de modifier le rôle SUPER ADMIN.');
        }

        $is_admin_role = $role_user->name === RoleName::ADMIN->value;

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $role_user->id],
            'permissions' => 'nullable|array',
        ]);

        if ($is_admin_role && $request->name !== RoleName::ADMIN->value) {
            return back()->with('message.error', 'Le nom du rôle ADMIN ne peut pas être modifié.');
        }

        if (!$is_admin_role && in_array($request->name, [RoleName::ADMIN->value, RoleName::SUPER_ADMIN->value])) {
            return back()->with('message.error', 'Le nom de rôle n\'est pas autorisé.');
        }

        DB::beginTransaction();
        if (!$is_admin_role) {
            $role_user->update(['name' => $request->name]);
        }
        $permissions = array_unique(array_merge($request->permissions ?? [], ['dashboard']));
        $role_user->syncPermissions($permissions);
        DB::commit();

        return back()->with('message.success', 'Enregistrement effectué');
    }

    public function destroy(Role $role_user)
    {
        if (in_array($role_user->name, [RoleName::SUPER_ADMIN->value, RoleName::ADMIN->value])) {
            return back()->with('message.error', 'Impossible de supprimer ce rôle.');
        }

        $role_user->delete();

        return back()->with('message.success', 'Rôle supprimé avec succès.');
    }
}
