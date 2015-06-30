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
            if (Auth::user()->usertype === 'user')
            {
                return view('auth.register')->with(['user' => Auth::user()]);
            }
            elseif(Auth::user()->usertype === 'company')
            {
//                dd($request->getRequestUri());
                return $next($request);
            }
        }

        return redirect('auth/login');
    }
}
