<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsBanned
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = '';
        if (isset(Auth::user()->role)) {
            $role = Auth::user()->role;
        }
        if (env("APP_MAINTENANCE") == 'true') {
            if ($role != 'admin') {
                if ($request->path() != 'login' ) {
                    return response(view('errors.maintenance'));
                }
            }
        }
        
        if (!Auth::guest() && Auth::user()->banned_at) {
            Auth::logout();
            return redirect('/login');
        }

        return $next($request);
    }
}