<?php

namespace App\Custom\Observers\Auth;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class EmailVerifications extends BaseObserver
{
    public static $listen = ['email.verified'];

    public function handle(User $user)
    {
        // $user->wallets()->create([
        //     'currency_id' => 1,
        //     'balance' => 0,
        // ]);
    }
}

