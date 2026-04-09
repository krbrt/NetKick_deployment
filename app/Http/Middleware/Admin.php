<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    // Check if user is logged in AND if their usertype is 'admin'
    if (auth()->check() && auth()->user()->usertype === 'admin') {
        return $next($request);
    }

    // If not admin, send them back to the user dashboard
    return redirect('dashboard')->with('error', 'Access denied.');
    }
}
