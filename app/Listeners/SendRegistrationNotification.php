<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class SendRegistrationNotification
{
    public function handle(Registered $event)
    {
        // Notify all admins about the new registration
        // $admins = User::where('is_admin', true)->get();
        // foreach ($admins as $admin) {
        //     Notification::create([
        //         'user_id' => $admin->id,
        //         'type' => 'registration',
        //         'message' => 'مستخدم جديد: ' . $event->user->name . ' قام بالتسجيل.',
        //     ]);
        // }
    }
}
