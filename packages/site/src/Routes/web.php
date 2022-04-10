<?php

Route::group(['middleware' => ['web','app.secure_header']], function () {

	Route::get('/', ['uses' => 'SiteController@index'])->name('site.index');

});