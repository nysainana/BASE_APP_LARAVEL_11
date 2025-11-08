<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();

        if (!$routeName) {
            return $next($request);
        }

        $userPermissions = $request->user()->getAllPermissionNames();
        $authorizedRoutes = $this->extractAuthorizedRoutes(Permission::PERMISSIONS_DATA, $userPermissions);

        if (in_array($routeName, $authorizedRoutes)) {
            return $next($request);
        }

        abort(403, 'ACTION NON AUTORISÉE.');
    }

    private function extractAuthorizedRoutes(array $permissionsData, array $userPermissions): array
    {
        $routes = [];
        foreach ($permissionsData as $item) {
            if (isset($item['is_group']) && $item['is_group']) {
                $routes = array_merge($routes, $this->extractAuthorizedRoutes($item['children'], $userPermissions));
            } else {
                if (in_array($item['key'], $userPermissions)) {
                    $routes = array_merge($routes, $item['routes']);
                }
            }
        }
        return array_unique($routes);
    }

}
