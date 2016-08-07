<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AllowIfAdmin
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
        dd($request);
        if ($this->auth)
        {
            $user = $this->auth->user();
            if ($user->role === 3) // is user
            {
                return $next($request);
            }
            else
            {
                return view('auth.register')->with(['user' => $user]);
            }
        }

        return redirect('auth/login');
    }
}
