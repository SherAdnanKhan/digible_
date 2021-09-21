<?php

namespace App\Providers;

use App\Custom\Observers\Auth\SendNotificationObserver;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('base64img', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['image/png', 'image/jpg', 'image/jpeg'];
            $format = str_replace(
                [
                    'data:',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }

            $fileBase64 = $explode[1];
            if (base64_decode($fileBase64, true) === false) {
                return false;
            }

            return true;
        });
        \App\Models\User::observe(new SendNotificationObserver());
    }
}
