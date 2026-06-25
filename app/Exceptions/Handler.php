<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session
     * on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        /**
         * ✅ Handle Session Expired / CSRF Token Mismatch
         * This prevents the ugly "419 Page Expired" screen.
         */
        $this->renderable(function (TokenMismatchException $e, Request $request) {

            // If API request (JSON)
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired. Please log in again.'
                ], 419);
            }

            // Redirect user back to login with message
            return redirect()
                ->route('login')
                ->with('info', ' Your session has expired. Please log in again.');
        });

        /**
         * Default reportable handler
         */
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
