<?php

Route::group(['middleware' => ['web', 'app.cms'], 'namespace' => 'Cms\Dashboard\Http\Controllers', 'prefix' => config('app.cms.admin_prefix')], function () {
	Route::get('dashboard','DashboardController@index')->name('cms.dashboard');	
});
