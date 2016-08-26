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

Artisan::command('publish', function () {
	exec('git checkout master');
	exec('git pull');
	exec('composer install');
	exec('php artisan migrate');
	exec('php artisan cache:clear');
	exec('ls ' . config('view.compiled') . DIRECTORY_SEPARATOR . '*.php');
});

Artisan::command('run', function () {
	exec('php artisan serve --port=80');
});