<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Agent
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
        if ($request->user() && $request->user()->status != 'Active') {
            // Redirect or return response if the condition fails
            return redirect()->route('agent.login')->with('error', 'You account is inactive');
        }
        // Check if the user is above a certain age (example)
        if ($request->user() && $request->user()->user_type != 'AGENT') {
            // Redirect or return response if the condition fails
            return redirect()->route('agent.login')->with('error', 'Unauthorized');
        }
        return $next($request);
    }
}
