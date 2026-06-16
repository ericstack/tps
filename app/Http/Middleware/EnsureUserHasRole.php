<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Restrict a route to users whose `access` level matches one of the
     * given roles. Mirrors the legacy `$_SESSION['access']` checks
     * (1 = admin, 2 = standard user).
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array((string) $user->access, $roles, true)) {
            abort(403, 'Insufficient permissions.');
        }

        return $next($request);
    }
}
