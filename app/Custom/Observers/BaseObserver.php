<?php

namespace App\Custom\Observers;

use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\Event;

abstract class BaseObserver
{
    public static $listen;

    static function schedule()
    {
        if (!isset(static::$listen)) {
            throw new ErrorException('exception.observer_listen_not_found');
        }

        $listener = get_called_class() . '@handle';
        $actions = is_string(static::$listen) ? explode(',', static::$listen) : static::$listen;
        foreach ($actions as $action) {
            Event::listen($action, $listener);
        }
    }
}
