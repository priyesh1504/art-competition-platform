<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show Login Page
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle Login + Account Lockout Logic
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Find user by email
        $user = User::where('email', $request->email)->first();

        // If account is locked
        if ($user && $user->is_locked) {
            return back()->withErrors([
                'email' => 'This account is locked after too many failed login attempts. Please contact the administrator.',
            ]);
        }

        // Attempt login
        if (
            Auth::attempt(
                $request->only('email', 'password'),
                $request->boolean('remember')
            )
        ) {
            // Reset attempts on success
            if ($user) {
                $user->update([
                    'failed_login_attempts' => 0,
                    'is_locked' => false,
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Login Failed
        if ($user) {
            $attempts = $user->failed_login_attempts + 1;
            $remaining = 5 - $attempts;

            // Lock account at 5 attempts
            if ($attempts >= 5) {
                $user->update([
                    'failed_login_attempts' => $attempts,
                    'is_locked' => true,
                ]);

                return back()->withErrors([
                    'email' => 'Account locked! Too many failed login attempts. Contact the administrator.',
                ]);
            }

            // Update attempts
            $user->update([
                'failed_login_attempts' => $attempts,
            ]);

            return back()->withErrors([
                'email' => "Invalid credentials. You have {$remaining} attempt(s) left before your account is locked.",
            ]);
        }

        // If user does not exist (security-safe message)
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Logout User
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}