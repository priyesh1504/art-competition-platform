<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeactivationRequestController extends Controller
{
    public function request(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'deactivation_requested' => true
        ]);

        return back()->with('info', 'Your request has been sent to the admin.');
    }
}
