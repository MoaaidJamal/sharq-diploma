<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (in_array(auth()->user()->type, [1, 3, 4, 5])) return $next($request);
            if (in_array(auth()->user()->type, [2, 3, 4, 5])) {
                if (!auth()->user()->phases()->count()) {
                    auth()->logout();
                    return redirect()->route('ws.login')->with('error', 'You are not included in any diploma');
                }
            }
            if ($request->route()->getName() == 'ws.profile' || $request->route()->getName() == 'ws.profile_post' || (auth()->user()->name && auth()->user()->gender && auth()->user()->country_id && auth()->user()->dob && auth()->user()->bio)) {
                return $next($request);
            } else {
                return redirect()->route('ws.profile')->with('warning', 'You need to fill your Personal Information to browse the website.');
            }
        }
        return redirect()->route('ws.login');
    }
}
