<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCaregiver
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND role is caregiver
        if (auth()->check() && auth()->user()->role === 'caregiver') {

            // Block caregiver if account is inactive
            if (!auth()->user()->is_active) {
                auth()->logout();

                return redirect()->route('login')
                    ->with('error', 'Your account has been deactivated. Contact the administrator.');
            }

            return $next($request);
        }

        abort(403, 'Access Denied');
    }
}
