<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Payment;
use App\Notifications\PaymentReceivedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class PaymentController extends Controller
{
    /**
     * 1. Initiate Stripe Checkout
     */
    public function checkout($id)
    {
        $competition = Competition::findOrFail($id);
        $user = Auth::user();

        // Block payment if competition is free
        if ($competition->fee <= 0) {
            return redirect()
                ->route('student.competitions.show', $competition->id)
                ->with('error', 'This competition is free. No payment required.');
        }

        // Check if already paid
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('competition_id', $competition->id)
            ->where('status', 'completed')
            ->first();

        if ($existingPayment) {
            return redirect()
                ->route('student.artworks.create', ['competition_id' => $competition->id])
                ->with('success', 'Payment already done. Submit your artwork now.');
        }

        // Stripe Setup
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create Stripe Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'customer_email' => $user->email,

            'payment_method_types' => ['card'],

            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => 'Competition Registration: ' . $competition->title,
                    ],
                    'unit_amount' => $competition->fee * 100,
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => route('student.payment.success', ['id' => $competition->id]),
            'cancel_url'  => route('student.payment.cancel', ['id' => $competition->id]),
        ]);

        return redirect()->away($session->url);
    }

    /**
     * 2. Payment Success Handler
     */
    public function success(Request $request, $id)
    {
        $user = Auth::user();
        $competition = Competition::findOrFail($id);

        // Prevent duplicate payment records
        $alreadyPaid = Payment::where('user_id', $user->id)
            ->where('competition_id', $competition->id)
            ->where('status', 'completed')
            ->first();

        if ($alreadyPaid) {
            return redirect()
                ->route('student.artworks.create', ['competition_id' => $competition->id])
                ->with('success', 'Payment already completed. Submit your artwork now.');
        }

        // Create Payment Record
        $payment = Payment::create([
            'user_id'        => $user->id,
            'competition_id' => $competition->id,
            'amount'         => $competition->fee,
            'currency'       => 'INR',
            'status'         => 'completed',
        ]);

        // Generate Receipt PDF
        $this->generateReceipt($payment);

        // Notify User (Email)
        $user->notify(new PaymentReceivedNotification($payment));

        return redirect()
            ->route('student.artworks.create', ['competition_id' => $competition->id])
            ->with('success', 'Payment Successful! Now submit your artwork.');
    }

    /**
     * 3. Payment Cancel Handler
     */
    public function cancel($id)
    {
        return redirect()
            ->route('student.competitions.show', $id)
            ->with('error', 'Payment cancelled.');
    }

    /**
     * 4. Show Receipt (DOWNLOAD PDF)
     */
    public function showReceipt($id)
    {
        $payment = Payment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check receipt exists
        if (!$payment->receipt_path || !Storage::disk('public')->exists($payment->receipt_path)) {
            return back()->with('error', 'Receipt file not found.');
        }

        // Open PDF in browser
        return response()->file(
            storage_path('app/public/' . $payment->receipt_path)
        );
    }

    /**
     * 5. Generate Receipt PDF (Helper)
     */
    private function generateReceipt($payment)
    {
        $data = [
            'user'        => $payment->user,
            'competition' => $payment->competition,
            'amount'      => $payment->amount,
            'currency'    => $payment->currency,

            // Full timestamp
            'date'        => $payment->created_at,

            'receipt_id'  => 'REC-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT),
        ];

        // Load PDF View
        $pdf = PDF::loadView('pdf.receipt', ['data' => $data]);

        // File Save Path
        $filename = 'receipt_' . $payment->id . '.pdf';
        $path = 'receipts/' . $filename;

        // Store PDF
        Storage::disk('public')->put($path, $pdf->output());

        // Save receipt path into DB
        $payment->update([
            'receipt_path' => $path
        ]);
    }
}