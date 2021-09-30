<?php

namespace App\Custom\Observers\Subscribers;

use App\Custom\Observers\BaseObserver;

class Notify extends BaseObserver
{
    public static $listen = ['subscribers.notify'];

    public function handle($data)
    {
        $users = $data['users'];
        $data = $data['collectionItem'];
        foreach ($users as $user) {
            dispatch(new \App\Jobs\SendNotificationJob($user, $data));
        }
    }
}
