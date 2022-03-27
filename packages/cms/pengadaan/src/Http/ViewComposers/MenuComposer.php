<?php

namespace Cms\Pengadaan\Http\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\View\View;


class MenuComposer
{
	protected $menus;

	public function __construct(Request $request){
		$this->menus = $request->session()->get('menus');
	}

    public function compose(View $view)
    {
        $view->with('menus', $this->menus);
    }
}