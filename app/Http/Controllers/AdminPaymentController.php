<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'competition'])->latest()->get();
        return view('admin.payments', compact('payments'));
    }

    public function destroy($id)
    {
        // Financial Integrity: Soft delete
        $payment = Payment::findOrFail($id);
        $payment->delete(); // This uses softDeletes
        return back()->with('success', 'Payment record archived.');
    }
}