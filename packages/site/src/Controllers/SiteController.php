<?php

namespace Site\Controllers;

use Illuminate\Http\Request;

class SiteController
{		

	public function index()
	{
		return view('site::index');
	}

}