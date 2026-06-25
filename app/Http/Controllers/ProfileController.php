<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        // Only students need age
        if ($request->user()->role === 'student') {
            $rules['age'] = ['required', 'integer', 'min:5'];
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
        ];

        if ($request->user()->role === 'student') {
            $data['age'] = $validated['age'];
        }

        $request->user()->update($data);

        return back()->with('status', 'profile-updated');
    }

    /**
     * Deactivate Account (NOT Delete)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();

        // Verify password first
        if (!Hash::check($request->password, $user->password)) {
            return redirect('/profile')->withErrors([
                'password' => 'Incorrect password.',
            ]);
        }

        // Deactivate account
        $user->update([
            'is_active' => 0,
        ]);

        // Logout immediately
        auth()->logout();

        // Clear session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Account deactivated successfully.');
    }

    /* =======================
       PASSWORD
    ======================= */

    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Password updated successfully.');
    }
}