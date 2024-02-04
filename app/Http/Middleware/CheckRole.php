<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->hasRole('admin')) {
            return redirect('/');
        }
        return $next($request);
    }
}