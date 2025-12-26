<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is above a certain age (example)
        if ($request->user() && $request->user()->user_type != 'ADMIN') {
            // Redirect or return response if the condition fails
            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        return $next($request);
    }
}
