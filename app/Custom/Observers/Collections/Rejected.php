<?php

namespace App\Custom\Observers\Collections;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class Rejected extends BaseObserver
{
    public static $listen = ['collection.rejected'];

    public function handle($data)
    {
        $user = User::find($data['user_id']);
        dispatch(new \App\Jobs\SendCollectionRejectedJob($user, $data));
    }
}
