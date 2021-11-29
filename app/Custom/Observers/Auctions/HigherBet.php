<?php

namespace App\Custom\Observers\Auctions;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class HigherBet extends BaseObserver
{
    public static $listen = ['auction.higher_bet'];

    public function handle($data)
    {
        $user = User::find($data['user_id']);
        dispatch(new \App\Jobs\HigherBetJob($data, $user));
    }
}
