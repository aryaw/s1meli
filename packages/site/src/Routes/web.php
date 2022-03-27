<?php

Route::group(['middleware' => ['web','app.secure_header']], function () {

	Route::get('/', ['uses' => 'SiteController@index'])->name('site.index');
	Route::get('about-us', ['uses' => 'SiteController@aboutUs'])->name('site.about-us');
	Route::get('term-and-condition', ['uses' => 'SiteController@term'])->name('site.term');
	Route::get('notification', ['uses' => 'SiteController@notification'])->name('site.notification');
		
	Route::post('login', ['uses' => 'UserController@login'])->name('site.login');
	Route::get('logout', ['uses' => 'UserController@logout'])->name('site.logout');	
	Route::get('register', ['uses' => 'UserController@register'])->name('site.register');
	Route::post('register', ['uses' => 'UserController@doRegister'])->name('site.do_register');	
	Route::get('forgot-password', ['uses' => 'UserController@forgotPassword'])->name('site.forgot_password');
	Route::post('forgot-password', ['uses' => 'UserController@doForgotPassword'])->name('site.do_forgot_password');
	Route::get('reset-password/{token}', ['uses' => 'UserController@resetPasswordForm'])->name('site.reset.form');
	Route::post('reset-password/{token}', ['uses' => 'UserController@resetPassword'])->name('site.reset');
	Route::get('activation/{token}', ['uses' => 'UserController@activate'])->name('site.activate');

	Route::get('auth/{provider}', 'UserController@redirectToProvider')->name('site.social.login');
	Route::get('auth/{provider}/callback', 'UserController@handleProviderCallback')->name('site.social.callback');	
	
	Route::get('planmydate/winner', ['uses' => 'ValentineController@winner'])->name('site.planmydate.winner');

	// dev
	Route::get('dev/session', ['uses' => 'DevelopmentController@session']);
	Route::get('dev/session-destroy', ['uses' => 'DevelopmentController@sessionDestroy']);
	Route::get('dev/email', ['uses' => 'DevelopmentController@email']);
	Route::get('dev/image', ['uses' => 'DevelopmentController@image']);
	Route::get('dev/canvas', ['uses' => 'DevelopmentController@canvas']);
	Route::get('dev/socialite', ['uses' => 'DevelopmentController@socialite']);
	Route::get('dev/datetime', ['uses' => 'DevelopmentController@datetime']);
	Route::get('dev/info', ['uses' => 'DevelopmentController@info']);

});

Route::group(['middleware' => ['web','app.secure_header','app.user']], function () {
	Route::post('planmydate/submit', ['uses' => 'ValentineController@submit'])->name('site.planmydate.submit');
});