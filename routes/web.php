<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// bindings

$router->bind('project', function ($value) {
    return App\Project::byKey($value);
});

$router->bind('projectTrashed', function ($value) {
    $project = App\Project::onlyTrashed()->byKey($value);
    if($project->count()) return $project;
    return App\Project;
});

// routes

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::get('invitation/{aff}', ['as' => 'invitation', 'uses' => 'HomeController@invitation']);
Route::get('terms-and-conditions', ['as' => 'termsAndConditions', function () {
    return view('page.terms-and-conditions');
}]);

Route::get('account', ['as' => 'account.detail', 'uses' => 'AccountController@detail']);
Route::get('account/edit', ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
Route::post('account/save', ['as' => 'account.save', 'uses' => 'AccountController@save']);
Route::get('account/refresh', ['as' => 'account.refresh', 'uses' => 'AccountController@refresh']);
Route::get('account/files', ['as' => 'account.files', 'uses' => 'AccountController@files']);
Route::get('account/trash', ['as' => 'account.trash', 'uses' => 'AccountController@trash']);
Route::match(['GET', 'POST'], 'account/invite', ['as' => 'account.invite', 'uses' => 'AccountController@invite']);

Route::get('order', ['as' => 'order.form', 'uses' => 'OrderController@form']);
Route::post('order', ['as' => 'order.save', 'uses' => 'OrderController@store']);
Route::get('order/list', ['as' => 'order.list', 'uses' => 'OrderController@orderList']);

Route::get('project/add', ['as' => 'project.add', 'uses' => 'ProjectController@add']);
Route::post('project/save', ['as' => 'project.add.save', 'uses' => 'ProjectController@saveNew']);
Route::get('project/{project}/update', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
Route::put('project/{project}/save', ['as' => 'project.update.save', 'uses' => 'ProjectController@save']);
Route::get('project/{project}/dashboard', ['as' => 'project.dashboard', 'uses' => 'ProjectController@dashboard']);
Route::get('project/{project}', ['as' => 'project.detail', 'uses' => 'ProjectController@detail']);
Route::get('project/{project}/delete', ['as' => 'project.delete', 'uses' => 'ProjectController@delete']);
Route::get('project/{projectTrashed}/renew', ['as' => 'project.renew', 'uses' => 'ProjectController@renew']);
Route::get('project/{projectTrashed}/force-delete', ['as' => 'project.delete.force', 'uses' => 'ProjectController@forceDelete']);
Route::get('project/file/{id}-{name}', ['as' => 'project.file.get', 'uses' => 'ProjectController@getFile']);
Route::get('project/file/download/{id}-{name}', ['as' => 'project.file.download', 'uses' => 'ProjectController@downloadFile']);
Route::get('project/file/delete/{id}-{name}', ['as' => 'project.file.delete', 'uses' => 'ProjectController@deleteFile']);

Route::get('task/{key}/add', ['as' => 'task.add', 'uses' => 'TaskController@add']);
Route::post('task/{key}/save', ['as' => 'task.add.save', 'uses' => 'TaskController@save']);
Route::get('task/{key}/update', ['as' => 'task.update', 'uses' => 'TaskController@update']);
Route::put('task/{key}/save', ['as' => 'task.update.save', 'uses' => 'TaskController@updateSave']);
Route::get('task/{key}', ['as' => 'task.detail', 'uses' => 'TaskController@detail']);
Route::get('task/{key}/status-change/{from}/2/{to}', ['as' => 'task.status.change', 'uses' => 'TaskController@statusChange']);
Route::get('task/{key}/renew', ['as' => 'task.renew', 'uses' => 'TaskController@renew']);
Route::get('task/{key}/force-delete', ['as' => 'task.delete.force', 'uses' => 'TaskController@forceDelete']);
Route::get('task/file/{id}-{name}', ['as' => 'task.file.get', 'uses' => 'TaskController@getFile']);
Route::get('task/file/download/{id}-{name}', ['as' => 'task.file.download', 'uses' => 'TaskController@downloadFile']);
Route::get('task/file/delete/{id}-{name}', ['as' => 'task.file.delete', 'uses' => 'TaskController@deleteFile']);

Route::get('admin', ['as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard']);
Route::get('admin/refresh', ['as' => 'admin.refresh', 'uses' => 'AdminController@refresh']);
Route::get('admin/backup-db', ['as' => 'admin.backup.db', 'uses' => 'AdminController@backupDb']);

Route::get('manual', ['as' => 'manual', 'uses' => 'HomeController@manual']);

Auth::routes();
$this->get('logout', 'Auth\LoginController@logout');