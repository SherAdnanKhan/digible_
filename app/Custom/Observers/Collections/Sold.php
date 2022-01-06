<?php

namespace App\Custom\Observers\Collections;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class Sold extends BaseObserver
{
    public static $listen = ['collection.sold'];

    public function handle($data)
    {
        $user = User::find($data['user_id']);
        dispatch(new \App\Jobs\SendCollectionSoldJob($user, $data));
    }
}
