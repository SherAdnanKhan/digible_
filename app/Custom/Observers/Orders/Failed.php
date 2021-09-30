<?php

namespace App\Custom\Observers\Orders;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class Failed extends BaseObserver
{
    public static $listen = ['orders.failed'];

    public function handle($data)
    {
        $user = User::find($data['order']['user_id']);
        dispatch(new \App\Jobs\SendOrderFailureJob($user, $data));
    }
}
