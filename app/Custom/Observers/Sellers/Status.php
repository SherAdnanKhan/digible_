<?php

namespace App\Custom\Observers\Sellers;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class Status extends BaseObserver
{
    public static $listen = ['seller.status'];

    public function handle($data)
    {
        $user = User::find($data['user_id']);
        dispatch(new \App\Jobs\SendSellerStatusJob($user, $data));
    }
}
