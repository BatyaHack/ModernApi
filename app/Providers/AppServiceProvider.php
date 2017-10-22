<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
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
        Validator::extend('test_popular_password', function ($attribute, $value, $parameters, $validator) {

            if (Storage::exists('password-list.txt')) {

                $password_list = explode(' ', Storage::get('password-list.txt'));

                for ($elem = 0; $elem < count($password_list); $elem++) {

                    if (strtolower($value) === strtolower($password_list[$elem])) {
                        return false; // пароль входит в топ популярных
                        break;
                    }

                }

                return true; // пароль не входит в топ популярных

            } else {
                return true; // если файла нет не проверяем популярность паролья
            }

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
