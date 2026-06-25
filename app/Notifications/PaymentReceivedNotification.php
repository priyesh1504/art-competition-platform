<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email + In-App Notification
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Payment Successful')
                    ->line('Your payment for ' . $this->payment->competition->title . ' was successful.')
                    ->line('Amount: $' . $this->payment->amount)
                    ->action('View Receipt', route('student.receipt', $this->payment->id))
                    ->line('Thank you for your support!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Payment Successful',
            'message' => 'You have successfully paid for ' . $this->payment->competition->title,
            'link' => route('student.receipt', $this->payment->id),
        ];
    }
}