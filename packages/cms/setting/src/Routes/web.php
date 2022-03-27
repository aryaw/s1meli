<?php 

Route::group([
	'middleware' => ['web', 'app.cms'], 
	'namespace' => 'Cms\Setting\Http\Controllers', 
	'prefix' => config('app.cms.admin_prefix').'/setting'
], function () {		
	
	Route::get('list','SettingController@index')->name('cms.setting.view');	
	Route::post('/','SettingController@store')->name('cms.setting.store');
	Route::get('delete/{id}','SettingController@delete')->name('cms.setting.delete')->where('id', '[0-9]+');	
	Route::put('update','SettingController@update')->name('cms.setting.update');	

});