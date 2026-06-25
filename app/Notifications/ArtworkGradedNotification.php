<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ArtworkGradedNotification extends Notification
{
    use Queueable;

    public $artwork;

    public function __construct($artwork)
    {
        $this->artwork = $artwork;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Role-based link
        if ($notifiable->role === 'caregiver') {
            $link = route('caregiver.dashboard');
        } elseif ($notifiable->role === 'teacher') {
            $link = route('teacher.grading.index');
        } elseif ($notifiable->role === 'admin') {
            $link = route('admin.grading.index');
        } else {
            // student fallback
            $link = route('student.certificates.index');
        }

        return [
            'title'   => 'Submission Graded',
            'message' => $this->artwork->student->name .
                         "'s artwork was graded. Score: " .
                         $this->artwork->score,
            'link'    => $link,
            'type'    => 'grade'
        ];
    }
}
