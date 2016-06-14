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

Route::get('/', ['as' => 'task.index', 'uses' => 'HomeController@index']);

Route::get('project/add', ['as' => 'project.add', 'uses' => 'ProjectController@add']);
Route::post('project/save', ['as' => 'project.add.save', 'uses' => 'ProjectController@save']);
Route::get('project/{id}/update', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
Route::put('project/{id}/save', ['as' => 'project.update.save', 'uses' => 'ProjectController@save']);
Route::get('project/{id}', ['as' => 'project.detail', 'uses' => 'ProjectController@detail']);
Route::get('task/{id}', ['as' => 'task', 'uses' => 'TaskController@detail']);

Route::auth();
