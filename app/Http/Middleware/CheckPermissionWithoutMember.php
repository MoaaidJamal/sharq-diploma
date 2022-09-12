<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermissionWithoutMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permission_ids)
    {
        if (auth('member')->check() || check_permission($permission_ids)) {
            return $next($request);
        } else {
            return redirect()->route('ws.login');
        }
    }
}
