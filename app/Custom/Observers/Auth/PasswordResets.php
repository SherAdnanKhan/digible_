<?php

namespace App\Custom\Observers\Auth;

use App\Custom\Observers\BaseObserver;
use App\Models\User;
use App\Notifications\Users\PasswordResetNotification;

class PasswordResets extends BaseObserver
{
    public static $listen = ['password.reset'];

    public function handle(User $user, string $token)
    {
        $user->notify(new PasswordResetNotification($token));
    }
}

