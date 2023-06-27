<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , string $role_name): Response
    {

        if(! auth()->check())
        {
            abort(401,'You are not logged in');
        };

        if(! auth()->user()->roles()->where('name',$role_name)->exists())
        {
            abort(403 , 'You Do Not Have The Access ');
        }

        return $next($request);
    }
}
