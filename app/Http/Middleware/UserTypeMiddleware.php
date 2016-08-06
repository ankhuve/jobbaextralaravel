<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserTypeMiddleware
{

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            if (Auth::user()->role === 1) // is user
            {
                return view('auth.register')->with(['user' => Auth::user()]);
            }
            elseif(Auth::user()->role === 2) // is company
            {
                return $next($request);
            }
            elseif(Auth::user()->role === 3) // is admin
            {
                return $next($request);
            }
        }

        return redirect('auth/login');
    }
}
