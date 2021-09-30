<?php

namespace App\Custom\Observers\Orders;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class Success extends BaseObserver
{
    public static $listen = ['orders.success'];

    public function handle($data)
    {
        $user = User::find($data['order']['user_id']);
        dispatch(new \App\Jobs\SendOrderSuccessJob($user, $data));
    }
}
