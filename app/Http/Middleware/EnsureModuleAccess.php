<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Gates a route group to users whose role grants the given module
// (config/roles.php). Usage: ->middleware('module:orders').
class EnsureModuleAccess
{
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if (! $user || ! $user->canAccessModule($module)) {
            abort(403, 'Insufficient permissions for this module.');
        }

        return $next($request);
    }
}
