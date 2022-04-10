<?php

namespace Cms\Dashboard\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Cms\Pengadaan\Http\Models\PengadaanModel;
use Cms\Pengadaan\Transformers\PengadaanTransformer;
use Sentinel;

class DashboardController extends Controller
{		

	public function index(Request $request)
	{
		$user = Sentinel::check();
		
		// pending waka
		$pengadaanModelActive = PengadaanModel::query()->normalPengadaanPendingWaka();
		$pending_waka = $pengadaanModelActive->count();

		// pending kepsek
		$pengadaanModelActive = PengadaanModel::query()->normalPengadaanPendingKepsek();
		$pending_kepsek = $pengadaanModelActive->count();

		return view('dashboard::index', ['pending_wakasek' => $pending_waka, 'pending_kepsek' => $pending_kepsek]);
	}

}
