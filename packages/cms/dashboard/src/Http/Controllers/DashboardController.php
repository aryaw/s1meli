<?php

namespace Cms\Dashboard\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Cms\Pengadaan\Http\Models\PengadaanModel;
use Cms\Pengadaan\Transformers\PengadaanTransformer;
use Cms\Pengadaan\Http\Models\ItemPengadaanModel;
use Cms\Pengadaan\Transformers\ItemPengadaanTransformer;
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
		
		// list barang pengadaan
		$barangPengadaan = ItemPengadaanModel::where('status', 1)->get();

		// list barang penerimaan
		$barangPenerimaan = ItemPengadaanModel::where('status', 2)->get();

		// list barang perbaikan
		$barangPerbaikan = ItemPengadaanModel::where('status', 3)->get();
		
		// list barang kerusakan
		$barangKerusakan = ItemPengadaanModel::where('status', 4)->get();

		return view('dashboard::index', [
			'pending_wakasek' => $pending_waka,
			'pending_kepsek' => $pending_kepsek,
			'barangPengadaan' => $barangPengadaan,
			'barangPenerimaan' => $barangPenerimaan,
			'barangPerbaikan' => $barangPerbaikan,
			'barangKerusakan' => $barangKerusakan,
		]);
	}

}
