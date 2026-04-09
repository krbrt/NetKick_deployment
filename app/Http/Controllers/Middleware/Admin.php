<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if the user is logged in
        // 2. Check if their usertype is 'admin'
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            return $next($request);
        }

        // If they are a regular user or not logged in,
        // redirect them to the dashboard with an error message
        return redirect('dashboard')->with('error', 'You do not have admin access.');
    }
}
