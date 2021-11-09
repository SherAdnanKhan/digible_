<?php

namespace App\Custom\Observers\Subscribers;

use App\Custom\Observers\BaseObserver;

class Favourite extends BaseObserver
{
    public static $listen = ['subscribers.favourite'];

    public function handle($data)
    {
        dispatch(new \App\Jobs\SendFavouriteJob($data));

    }
}
