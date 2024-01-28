<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , string $role): Response
    {
        if(! auth()->check()){
            abort(401) ;
        }

        if(! auth()->user()->roles()->where('name' , $role)->exists()){
            return response()->json([
                'middleware' => 'only ' . $role . ' is allowed to access this endpoint ' ,
            ],403);
        }

        return $next($request);
    }
}
