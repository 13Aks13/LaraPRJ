<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   //!Auth::user()->isAdmin()

        $user = Auth::user();
        $role_id = $user->role_id;

        if ($role_id !== 1 ) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
