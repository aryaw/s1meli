<?php
Route::group(['middleware' => ['web', 'app.cms'], 'namespace' => 'Cms\Pengadaan\Http\Controllers', 'prefix' => config('app.cms.admin_prefix')], function () {	
	// pengadaan
	Route::get('pengadaan/list','PengadaanController@index')->name('cms.pengadaan.view');
	Route::post('pengadaan/list','PengadaanController@list')->name('cms.pengadaan.list');
	Route::get('pengadaan/list/detail/{id}','PengadaanController@detail')->name('cms.pengadaan.detail')->where('id', '[0-9]+');
	Route::get('pengadaan/list/delete/{id}','PengadaanController@delete')->name('cms.pengadaan.delete')->where('id', '[0-9]+');
	
	Route::get('pengadaan/create','PengadaanController@create')->name('cms.pengadaan.create');
	Route::post('pengadaan/store','PengadaanController@store')->name('cms.pengadaan.store');
	
	Route::get('pengadaan/edit/{id}','PengadaanController@edit')->name('cms.pengadaan.edit')->where('id', '[0-9]+');
	Route::post('pengadaan/update/{id}','PengadaanController@update')->name('cms.pengadaan.update')->where('id', '[0-9]+');
	// Route::post('pengadaan/export','PengadaanController@export');
});



