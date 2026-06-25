<?php

namespace App\Http\Controllers;

use App\Models\User;

class AccountDeactivationController extends Controller
{
    public function index()
    {
        $requests = User::where('deactivation_requested', true)
                        ->where('is_active', true)
                        ->get();

        return view('admin.deactivation-requests', compact('requests'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => false,
            'deactivation_requested' => false,
        ]);

        return back()->with('success', 'User account has been deactivated.');
    }

    public function reactivate($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => true,
        ]);

        return back()->with('success', 'User account reactivated.');
    }
}
