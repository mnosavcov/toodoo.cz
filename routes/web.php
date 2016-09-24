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

$router->bind('project', function ($value, $route) {
    return App\Project::byKey($value, $route->getParameter('owner'))->first();
});

$router->bind('projectTrashed', function ($value) {
    return App\Project::onlyTrashed()->byKey($value)->first();
});

// routes

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::get('invitation/{aff}', ['as' => 'invitation', 'uses' => 'HomeController@invitation']);
Route::get('terms-and-conditions', ['as' => 'termsAndConditions', function () {
    return view('page.terms-and-conditions', ['page' => true]);
}]);
Route::get('manual', ['as' => 'manual', function () {
    return view('page.manual', ['page' => true]);
}]);
Route::get('contact', ['as' => 'contact', function () {
    return view('page.contact', ['page' => true]);
}]);
Route::get('about', ['as' => 'about', function () {
    return view('page.about', ['page' => true]);
}]);
Route::get('changelog', ['as' => 'changelog', function () {
    return view('page.changelog', ['page' => true]);
}]);

Route::get('account', ['as' => 'account.detail', 'uses' => 'AccountController@detail']);
Route::get('account/edit', ['as' => 'account.edit', 'uses' => 'AccountController@edit']);
Route::post('account/save', ['as' => 'account.save', 'uses' => 'AccountController@save']);
Route::get('account/refresh', ['as' => 'account.refresh', 'uses' => 'AccountController@refresh']);
Route::get('account/files', ['as' => 'account.files', 'uses' => 'AccountController@files']);
Route::get('account/trash', ['as' => 'account.trash', 'uses' => 'AccountController@trash']);
Route::match(['GET', 'POST'], 'account/invite', ['as' => 'account.invite', 'uses' => 'AccountController@invite']);
Route::get('account/activation/{email}/{token}', ['as' => 'account.activation', 'uses' => 'ActivationController@activate']);
Route::get('account/reactivate', ['as' => 'account.reactivate', 'uses' => 'ActivationController@reactivate']);

Route::get('order', ['as' => 'order.form', 'uses' => 'OrderController@form']);
Route::post('order', ['as' => 'order.save', 'uses' => 'OrderController@store']);
Route::get('order/list', ['as' => 'order.list', 'uses' => 'OrderController@orderList']);

Route::get('project/add', ['as' => 'project.add', 'uses' => 'ProjectController@add']);
Route::post('project/save', ['as' => 'project.add.save', 'uses' => 'ProjectController@saveNew']);
    Route::get('project/file/{id}-{name}', ['as' => 'project.file.get', 'uses' => 'ProjectController@getFile']);
    Route::get('project/file/download/{id}-{name}', ['as' => 'project.file.download', 'uses' => 'ProjectController@downloadFile']);
    Route::get('project/file/delete/{id}-{name}', ['as' => 'project.file.delete', 'uses' => 'ProjectController@deleteFile']);
    Route::get('project/{project}/update', ['as' => 'project.update', 'uses' => 'ProjectController@update']);
    Route::put('project/{project}/save', ['as' => 'project.update.save', 'uses' => 'ProjectController@save']);
Route::get('project/{project}/dashboard/{owner?}', ['as' => 'project.dashboard', 'uses' => 'ProjectController@dashboard']);
    Route::get('project/{project}', ['as' => 'project.detail', 'uses' => 'ProjectController@detail']);
    Route::get('project/{project}/delete', ['as' => 'project.delete', 'uses' => 'ProjectController@delete']);
    Route::get('project/{projectTrashed}/renew', ['as' => 'project.renew', 'uses' => 'ProjectController@renew']);
    Route::get('project/{projectTrashed}/force-delete', ['as' => 'project.delete.force', 'uses' => 'ProjectController@forceDelete']);
    Route::post('project/{project}/participant/add', ['as' => 'project.participant.add', 'uses' => 'ProjectController@addParticipant']);
    Route::delete('project/{project}/participant/{participant_id}/remove', ['as' => 'project.participant.remove', 'uses' => 'ProjectController@removeParticipant']);

    Route::get('task/file/{id}-{name}', ['as' => 'task.file.get', 'uses' => 'TaskController@getFile']);
    Route::get('task/file/download/{id}-{name}', ['as' => 'task.file.download', 'uses' => 'TaskController@downloadFile']);
    Route::get('task/file/delete/{id}-{name}', ['as' => 'task.file.delete', 'uses' => 'TaskController@deleteFile']);
Route::get('task/{key}/add/{owner?}', ['as' => 'task.add', 'uses' => 'TaskController@add']);
Route::post('task/{key}/save/{owner?}', ['as' => 'task.add.save', 'uses' => 'TaskController@save']);
Route::get('task/{key}/update/{owner?}', ['as' => 'task.update', 'uses' => 'TaskController@update']);
Route::put('task/{key}/save/{owner?}', ['as' => 'task.update.save', 'uses' => 'TaskController@updateSave']);
Route::get('task/{key}/status-change/{from}/2/{to}/{owner?}', ['as' => 'task.status.change', 'uses' => 'TaskController@statusChange']);
Route::get('task/{key}/renew', ['as' => 'task.renew', 'uses' => 'TaskController@renew']);
Route::get('task/{key}/force-delete', ['as' => 'task.delete.force', 'uses' => 'TaskController@forceDelete']);
Route::get('task/{key}/{owner?}', ['as' => 'task.detail', 'uses' => 'TaskController@detail']);


Route::get('admin', ['as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard']);
Route::get('admin/refresh', ['as' => 'admin.refresh', 'uses' => 'AdminController@refresh']);
Route::get('admin/backup-db', ['as' => 'admin.backup.db', 'uses' => 'AdminController@backupDb']);

Route::get('user/ajax/get-by-email', ['as' => 'user.ajax.getByEmail', 'uses' => 'UserController@ajax_getByEmail']);

Auth::routes();
$this->get('logout', 'Auth\LoginController@logout');