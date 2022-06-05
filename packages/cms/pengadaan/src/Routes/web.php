<?php
Route::group(['middleware' => ['web', 'app.cms'], 'namespace' => 'Cms\Pengadaan\Http\Controllers', 'prefix' => config('app.cms.admin_prefix')], function () {	
	// pengadaan
	Route::get('pengadaan/list','PengadaanController@index')->name('cms.pengadaan.view');
	Route::post('pengadaan/list','PengadaanController@list')->name('cms.pengadaan.list');
	Route::get('pengadaan/list/delete/{id}','PengadaanController@delete')->name('cms.pengadaan.delete')->where('id', '[0-9]+');
	
	Route::get('pengadaan/create','PengadaanController@create')->name('cms.pengadaan.create');
	Route::post('pengadaan/store','PengadaanController@store')->name('cms.pengadaan.store');
	
	Route::get('pengadaan/edit/{id}','PengadaanController@edit')->name('cms.pengadaan.edit')->where('id', '[0-9]+');
	Route::post('pengadaan/update/{id}','PengadaanController@update')->name('cms.pengadaan.update')->where('id', '[0-9]+');
	
	Route::get('pengadaan/show/{id}','PengadaanController@show')->name('cms.pengadaan.show')->where('id', '[0-9]+');
	Route::post('pengadaan/updatebyrole/{id}','PengadaanController@updateByRole')->name('cms.pengadaan.updatebyrole')->where('id', '[0-9]+');

	// penerimaan
	Route::get('penerimaan/list','PenerimaanController@index')->name('cms.penerimaan.view');
	Route::post('penerimaan/list','PenerimaanController@list')->name('cms.penerimaan.list');
	Route::get('penerimaan/list/delete/{id}','PenerimaanController@delete')->name('cms.penerimaan.delete')->where('id', '[0-9]+');
	
	Route::get('penerimaan/create','PenerimaanController@create')->name('cms.penerimaan.create');
	Route::post('penerimaan/store','PenerimaanController@store')->name('cms.penerimaan.store');
	
	Route::get('penerimaan/edit/{id}','PenerimaanController@edit')->name('cms.penerimaan.edit')->where('id', '[0-9]+');
	Route::post('penerimaan/update/{id}','PenerimaanController@update')->name('cms.penerimaan.update')->where('id', '[0-9]+');
	
	Route::get('penerimaan/show/{id}','PenerimaanController@show')->name('cms.penerimaan.show')->where('id', '[0-9]+');
	Route::post('penerimaan/updatebyrole/{id}','PenerimaanController@updateByRole')->name('cms.penerimaan.updatebyrole')->where('id', '[0-9]+');

	Route::get('penerimaan/edit-nota/{id}','PenerimaanController@editNota')->name('cms.penerimaan.editnota')->where('id', '[0-9]+');
	Route::post('penerimaan/update-nota/{id}','PenerimaanController@updateNota')->name('cms.penerimaan.updatenota')->where('id', '[0-9]+');
	

	// perbaikan
	Route::get('perbaikan/list','PerbaikanController@index')->name('cms.perbaikan.view');
	Route::post('perbaikan/list','PerbaikanController@list')->name('cms.perbaikan.list');
	Route::get('perbaikan/list/delete/{id}','PerbaikanController@delete')->name('cms.perbaikan.delete')->where('id', '[0-9]+');
	
	Route::get('perbaikan/create','PerbaikanController@create')->name('cms.perbaikan.create');
	Route::post('perbaikan/store','PerbaikanController@store')->name('cms.perbaikan.store');
	
	Route::get('perbaikan/edit/{id}','PerbaikanController@edit')->name('cms.perbaikan.edit')->where('id', '[0-9]+');
	Route::get('perbaikan/editbyrole/{id}','PerbaikanController@editByRole')->name('cms.perbaikan.editbyrole')->where('id', '[0-9]+');
	Route::post('perbaikan/update/{id}','PerbaikanController@update')->name('cms.perbaikan.update')->where('id', '[0-9]+');

	Route::get('perbaikan/show/{id}','PerbaikanController@show')->name('cms.perbaikan.show')->where('id', '[0-9]+');
	Route::post('perbaikan/updatebyrole/{id}','PerbaikanController@updateByRole')->name('cms.perbaikan.updatebyrole')->where('id', '[0-9]+');

	// kerusakan
	Route::get('kerusakan/list','KerusakanController@index')->name('cms.kerusakan.view');
	Route::post('kerusakan/list','KerusakanController@list')->name('cms.kerusakan.list');
	Route::get('kerusakan/list/detail/{id}','KerusakanController@detail')->name('cms.kerusakan.detail')->where('id', '[0-9]+');
	Route::get('kerusakan/list/delete/{id}','KerusakanController@delete')->name('cms.kerusakan.delete')->where('id', '[0-9]+');
	
	Route::get('kerusakan/create','KerusakanController@create')->name('cms.kerusakan.create');
	Route::post('kerusakan/store','KerusakanController@store')->name('cms.kerusakan.store');
	
	Route::get('kerusakan/edit/{id}','KerusakanController@edit')->name('cms.kerusakan.edit')->where('id', '[0-9]+');
	Route::get('kerusakan/editbyrole/{id}','KerusakanController@editByRole')->name('cms.kerusakan.editbyrole')->where('id', '[0-9]+');
	Route::post('kerusakan/update/{id}','KerusakanController@update')->name('cms.kerusakan.update')->where('id', '[0-9]+');

	Route::get('kerusakan/show/{id}','KerusakanController@show')->name('cms.kerusakan.show')->where('id', '[0-9]+');
	Route::post('kerusakan/updatebyrole/{id}','KerusakanController@updateByRole')->name('cms.kerusakan.updatebyrole')->where('id', '[0-9]+');


	// barang
	Route::get('barang/list','BarangController@index')->name('cms.barang.view');
	Route::post('barang/list','BarangController@list')->name('cms.barang.list');
	Route::get('barang/list/detail/{id}','BarangController@detail')->name('cms.barang.detail')->where('id', '[0-9]+');
	Route::get('barang/list/delete/{id}','BarangController@delete')->name('cms.barang.delete')->where('id', '[0-9]+');
	
	Route::get('barang/create','BarangController@create')->name('cms.barang.create');
	Route::post('barang/store','BarangController@store')->name('cms.barang.store');
	
	Route::get('barang/edit/{id}','BarangController@edit')->name('cms.barang.edit')->where('id', '[0-9]+');
	Route::post('barang/update/{id}','BarangController@update')->name('cms.barang.update')->where('id', '[0-9]+');
});



