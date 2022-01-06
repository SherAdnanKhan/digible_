<?php

namespace App\Custom\Observers\Collections;

use Illuminate\Support\Facades\Auth;
use App\Custom\Observers\BaseObserver;

class Store extends BaseObserver
{
    public static $listen = ['collection.store'];

    public function handle($data)
    {
        $user = Auth::user();
        dispatch(new \App\Jobs\SendCollectionStoreJob($user, $data));
    }
}
