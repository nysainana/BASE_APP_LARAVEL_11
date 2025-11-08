<?php

namespace App\Http\Controllers;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $filters = Validator::make($request->all(), [
            "search" => "sometimes|string",
            "roles" => "sometimes|array",
        ])->safe()->all();

        $search = $filters["search"] ?? null;
        $f_roles = $filters["roles"] ?? null;

        $data = User::query()
            ->whereHas("roles", function ($q) use ($request) {
                $q->when(!$request->user()->hasRole(RoleName::SUPER_ADMIN->value), fn($query) => $query->where("name", "!=", RoleName::SUPER_ADMIN->value));
            })
            ->when($search, fn ($q) => $q->whereLike("name", "%{$search}%"))
            ->when($f_roles, fn ($q) => $q->role(array_filter($f_roles, fn($r) => $r != 0)))
            ->orderBy("name");

        $roles = Role::query()
            ->when(!$request->user()->hasRole(RoleName::SUPER_ADMIN->value), function($query) {
                $query->where('name', '!=', RoleName::SUPER_ADMIN->value);
            })
            ->orderBy('name')
            ->get()
            ->map(fn ($role) => ["label" => $role->name, "value" => $role->name]);

        return Inertia::render("User/Index", [
            "data" => $data->paginate(config("app.pagination.per_page")),
            "extra_data" => [
                "roles" => $roles,
            ],
            "filters" => [
                "search" => $search,
                "roles" => $f_roles ?? [],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'tel' => 'nullable|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => "required|exists:roles,name"
        ]);

        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->role);
        DB::commit();

        return back()->with("message.success", "Enrégistrement effectuer");
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|lowercase|email|max:255|unique:users,email,{$user->id}",
            'tel' => 'nullable|string|max:255',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => "required|exists:roles,name"
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel
        ];
        if($request->password) $data["password"] = Hash::make($request->password);

        DB::beginTransaction();
        $user->update($data);

        $user->syncRoles($request->role);
        DB::commit();

        return back()->with("message.success", "Enrégistrement effectuer");
    }

    public function destroy(Request $request, User $user)
    {
        if (User::count() <= 1) {
            return back()->with('message.error', 'Impossible de supprimer le dernier utilisateur.');
        }

        if ($user->id === $request->user()->id) {
            return back()->with('message.error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->hasRole(RoleName::SUPER_ADMIN->value) && !$request->user()->hasRole(RoleName::SUPER_ADMIN->value)) {
            return back()->with('message.error', 'Vous n\'êtes pas autorisé à supprimer un SUPER ADMIN.');
        }

        $user->delete();

        return back()->with('message.success', 'Utilisateur supprimé avec succès.');
    }

}
