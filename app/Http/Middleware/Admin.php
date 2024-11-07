<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return redirect()->route('login')->withErrors(['error' => 'You need to log in to access this page.']);
        }

        // Check if the user role is 'admin'
        if ($request->user()->role === 'admin') {
            return $next($request); // Proceed to the next middleware or request handler
        }

        // Flash error message for unauthorized access
        session()->flash('error', 'You do not have permission to access this page');

        // Redirect to the appropriate route based on user role
        return redirect()->route($request->user()->role);
    }
}
