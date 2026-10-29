<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Reject anyone who is not an administrator before the controller runs.
     *
     * Because this sits on the route, typing a management URL by hand is stopped
     * even though the Blade buttons are hidden from regular users.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN, 'Only administrators can manage products.');
        }

        return $next($request);
    }
}
