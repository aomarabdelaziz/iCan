<?php

namespace App\Drivers;
use Illuminate\Notifications\Notification;

class FirebaseById
{
    public function send ($notifiable, Notification $notification)
    {
        $data = $notification->toFirebaseById($notifiable);
    }
}
