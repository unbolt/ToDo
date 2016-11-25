<?php

Route::group(['middlewhere' => ['auth']], function() {
	Route::get('/', 'DashboardController@index');
});

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['auth'], 'namespace' => 'Admin'], function () {
    CRUD::resource('task', 'TaskCrudController');
    CRUD::resource('project', 'ProjectCrudController');

    Route::get('/task/{id}/{status}', 'TaskCrudController@changeStatus');
});