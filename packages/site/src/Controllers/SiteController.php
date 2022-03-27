<?php

namespace Site\Controllers;

use Illuminate\Http\Request;

class SiteController
{		

	public function index()
	{
		return view('site::index');
	}
	
	public function notification(Request $request){
		if($request->session()->has('message')){
			return view('site::notification', [
				'message' => $request->session()->get('message'),
			]);
		}		
		return redirect()->route('site.index');
	}

	public function aboutUs(){
		return view('site::about_us');
	}

	public function contact(){
		return view('site::contact');
	}

	public function term(){
		return view('site::term');
	}

	public function privacyPolicy(){
		return view('site::privacy_policy');
	}

}