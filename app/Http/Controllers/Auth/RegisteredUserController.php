<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],

                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email:rfc,dns',
                    'max:255',
                    'unique:' . User::class,
                ],

                'password' => [
                    'required',
                    'confirmed',
                    Rules\Password::defaults(),
                ],

                'role' => [
                    'required',
                    'in:student,teacher,caregiver,admin',
                ],

                'age' => [
                    'required_if:role,student',
                    'nullable',
                    'integer',
                    'min:5',
                    'max:15',
                ],
            ],
            [
                'age.required_if' => 'Age is required for students.',
                'age.min' => 'Student age must be at least 5.',
                'age.max' => 'Student age must not be more than 15.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'age' => $request->role === 'student' ? $request->age : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}