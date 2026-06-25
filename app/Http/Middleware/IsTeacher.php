<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND role is teacher
        if (auth()->check() && auth()->user()->role === 'teacher') {

            // Block teacher if account is inactive
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
