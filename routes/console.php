<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('publish {--migrate}', function () {
    $migrate = $this->option('migrate');

    exec('git checkout master');
    exec('git pull');
    exec('composer install');
    if ($migrate) {
        exec('php artisan migrate --force');
    }
	exec('php artisan view:clear');
	exec('php artisan cache:clear');
});

Artisan::command('run', function () {
    exec('php artisan serve --port=80');
});