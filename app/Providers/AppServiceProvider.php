<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // last user activity log
        $user = Auth::user();
        if ($user) {
            $user->last_activity_at = time();
            $user->save();
        }
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
