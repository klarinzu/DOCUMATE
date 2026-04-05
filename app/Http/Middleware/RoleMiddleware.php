<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // Check if user exists
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Check if role exists
        if (!$user->role) {
            abort(403, 'No role assigned');
        }

        // Normalize roles (case-insensitive)
        $userRole = strtolower($user->role->role_name);
        $allowedRoles = array_map('strtolower', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}