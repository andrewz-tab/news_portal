<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BanPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getRequestUri() === '/ban') {
            if (optional(auth()->user())->is_banned === null) {
                abort(404);
            } else if (boolval(optional(auth()->user())->is_banned) === false) {
                abort(404);
            }
            return $next($request);
        }
        return $next($request);
    }

}
