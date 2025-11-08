<?php

namespace App\Http\Controllers;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            "stats" => $this->_getStat($request),
        ];

        return Inertia::render('Dashboard/Index', [
            "data" => $data,
        ]);
    }

    private function _getStat(Request $request)
    {
        $stats = [];

        if ($request->user()->can('dashboard.view_user_stat')) {
            $stats['user'] = User::when(
                !$request->user()->hasRole(RoleName::SUPER_ADMIN->value),
                fn (Builder $query) => $query->withoutRole(RoleName::SUPER_ADMIN->value)
            )->count();
        }

        return $stats;
    }
}
