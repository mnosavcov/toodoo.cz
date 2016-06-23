<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::get('project/add', ['as' => 'project.add', 'uses' => 'ProjectController@add']);
Route::post('project/save', ['as' => 'project.add.save', 'uses' => 'ProjectController@save']);
Route::get('project/{key}/update', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
Route::put('project/{key}/save', ['as' => 'project.update.save', 'uses' => 'ProjectController@save']);
Route::get('project/{key}', ['as' => 'project.dashboard', 'uses' => 'ProjectController@dashboard']);
Route::get('project/{key}/detail', ['as' => 'project.detail', 'uses' => 'ProjectController@detail']);

Route::get('task/{key}/add', ['as' => 'task.add', 'uses' => 'TaskController@add']);
Route::post('task/{key}/save', ['as' => 'task.add.save', 'uses' => 'TaskController@save']);
Route::get('task/{id}', ['as' => 'task.detail', 'uses' => 'TaskController@detail']);

Route::auth();
