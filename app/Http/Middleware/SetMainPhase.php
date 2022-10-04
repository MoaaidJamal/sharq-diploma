<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetMainPhase
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
        if ($request->set_main_phase) {
            if (session('dashboard_phase_id') == $request->set_main_phase) {
                session()->forget('dashboard_phase_id');
            } else {
                session()->put('dashboard_phase_id', $request->set_main_phase);
            }
            return redirect(url()->current());
        }
        return $next($request);
    }
}
