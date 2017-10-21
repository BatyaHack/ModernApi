<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // можно мереенсти в класс и
        // Validator::extend('foo', 'FooValidator@validate');
        // 1 - имя правила, класс и метода
        Validator::extend('foo', function ($attribute, $value, $parameters, $validator) {
            return !($value == 'Qwerty1997!');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
