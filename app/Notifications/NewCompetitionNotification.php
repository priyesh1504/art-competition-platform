<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCompetitionNotification extends Notification
{
    use Queueable;

    public $competition;

    public function __construct($competition)
    {
        $this->competition = $competition;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Correct link depending on role
        $link = match ($notifiable->role) {

            'admin' =>
                route('admin.competitions.show', $this->competition->id),

            'teacher' =>
                route('teacher.competitions.index'),

            'student' =>
                route('student.dashboard'),

            'caregiver' =>
                route('caregiver.dashboard'),

            default =>
                route('dashboard'),
        };

        return [
            'title'   => '🎨 New Competition Announced!',
            'message' => 'A new competition "' . $this->competition->title . '" is now available!',
            'link'    => $link,
            'type'    => 'competition',
        ];
    }
}
