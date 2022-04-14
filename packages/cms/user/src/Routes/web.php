<?php

Route::group(['middleware' => 'web', 'namespace' => 'Cms\User\Http\Controllers'], function () {
	Route::get(config('app.cms.admin_prefix'), 'UserController@prefix');
	Route::get('activate/{token}','AdminController@activateForm')->name('cms.admin.activate.form');
	Route::post('activate/{token}','AdminController@activateWithPassword')->name('cms.admin.activate');
});

Route::group(['middleware' => ['web'], 'namespace' => 'Cms\User\Http\Controllers', 'prefix' => config('app.cms.admin_prefix')], function () {
	Route::get('login','AdminController@login')->name('cms.login');
	Route::get('logout','AdminController@logout')->name('cms.logout');
	Route::post('login','AdminController@doLogin')->name('cms.dologin');
	Route::get('forgot-password','AdminController@forgotPasswordForm')->name('user.forgotpassword');

	Route::post('toggle-menu','AdminController@toggleMenu');
});

Route::group(['middleware' => ['web', 'app.cms'], 'namespace' => 'Cms\User\Http\Controllers', 'prefix' => config('app.cms.admin_prefix')], function () {	
	// roles
	Route::get('user/role','RoleController@index')->name('cms.role.view');
	Route::get('user/role/create','RoleController@create')->name('cms.role.create');
	Route::get('user/role/edit/{id}','RoleController@edit')->name('cms.role.edit')->where('id', '[0-9]+');
	Route::post('user/role/list','RoleController@list')->name('cms.role.list');
	Route::post('user/role','RoleController@store')->name('cms.role.store');
	Route::put('user/role/{id}','RoleController@update')->name('cms.role.update')->where('id', '[0-9]+');
	Route::get('user/role/delete/{id}','RoleController@delete')->name('cms.role.delete')->where('id', '[0-9]+');

	// user role management
	Route::get('user/rmanagement','RoleManagementController@index')->name('cms.rolemanagement.create');
	Route::post('user/rmanagement','RoleManagementController@store')->name('cms.rolemanagement.store');
	
	// admin
	Route::get('admin','AdminController@index')->name('cms.admin.view');
	Route::post('admin/list','AdminController@list')->name('cms.admin.list');
	
	Route::get('admin/create','AdminController@create')->name('cms.admin.create');
	Route::post('admin/store','AdminController@store')->name('cms.admin.store');
	
	Route::get('admin/edit/{id}','AdminController@edit')->name('cms.admin.edit')->where('id', '[0-9]+');
	Route::post('admin/update/{id}','AdminController@update')->name('cms.admin.update')->where('id', '[0-9]+');
	
	Route::get('admin/delete/{id}','AdminController@delete')->name('cms.admin.delete')->where('id', '[0-9]+');	

	// user
	Route::get('user/list','UserController@index')->name('cms.user.view');
	Route::post('user/list','UserController@list')->name('cms.user.list');
	Route::get('user/list/detail/{id}','UserController@detail')->name('cms.user.detail')->where('id', '[0-9]+');
	Route::get('user/list/delete/{id}','UserController@delete')->name('cms.user.delete')->where('id', '[0-9]+');
	
	Route::get('user/create','UserController@create')->name('cms.user.create');
	Route::post('user/store','UserController@store')->name('cms.user.store');
	
	Route::get('user/edit/{id}','UserController@edit')->name('cms.user.edit')->where('id', '[0-9]+');
	Route::post('user/update/{id}','UserController@update')->name('cms.user.update');
	
	Route::get('user/editpasswd/{id}','UserController@editPasswd')->name('cms.user.editpasswd')->where('id', '[0-9]+');
	Route::post('user/updatepasswd/{id}','UserController@updatepasswd')->name('cms.user.updatepasswd');
	// Route::post('user/export','UserController@export');

	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});



