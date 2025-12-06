<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsStaffOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!auth()->check() || !in_array(auth()->user()->role, ['admin','staff'])) {
        return redirect('/')->with('error', 'Unauthorized.');
    }
    return $next($request);
}

}
