<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $default_guards = array_keys(\config('auth')['guards']);
        $guards = empty($guards) ? $default_guards : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // $home = strtoupper($guard).'_HOME';
                // $url = constant(RouteServiceProvider::class . '::' . $home);
                $url = url('/');
                if(Auth::user()->type == 'admin'){
                    $url = route('admin.home');
                }else{
                    $url = route('user.home');
                }
                return redirect($url);
            }
        }

        return $next($request);
    }
}
