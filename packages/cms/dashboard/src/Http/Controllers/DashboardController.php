<?php

namespace Cms\Dashboard\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{		

	public function index(Request $request)
	{
		#dd(\Sentinel::getUser()->name);
		#dd($data = $request->session()->all());		
		#dd($request->session()->get('menus'));

		return view('dashboard::index');
	}

}
