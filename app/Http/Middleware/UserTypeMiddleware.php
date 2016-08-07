<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $roles = [
            'admin'     => 3,
            'company'   => 2,
            'user'      => 1
        ];

        if ($request->user()->role != ($roles[$role])) {
            return view('auth.register')->with(['user' => Auth::user()]);
//            return redirect('auth/login');
        }

        return $next($request);


    }
}
