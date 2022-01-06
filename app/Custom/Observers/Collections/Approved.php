<?php

namespace App\Custom\Observers\Collections;

use App\Custom\Observers\BaseObserver;
use App\Models\User;

class Approved extends BaseObserver
{
    public static $listen = ['collection.approved'];

    public function handle($data)
    {
        $user = User::find($data['user_id']);
        dispatch(new \App\Jobs\SendCollectionApprovedJob($user, $data));
    }
}
