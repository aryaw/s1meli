<?php

namespace Cms\Pengadaan\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Cms\Pengadaan\Http\Models\PengadaanModel;
use Cms\Pengadaan\Http\Models\PengadaanHistoryModel;
use Cms\Pengadaan\Http\Models\ItemPengadaanModel;
use Cms\Pengadaan\Transformers\PengadaanTransformer;
use DB;
use Cms\User\Http\Models\UserModel;
use Sentinel;

class PerbaikanController extends Controller
{		
	

	public function index()
	{
		$user = Sentinel::check();
        if($user) {
            $roles = $user->roles()->first()->slug;
            return view('pengadaan::perbaikan.index', ['roles' => $roles]);
        }
	}

    public function prefix(Request $request){
        if(Sentinel::check()){
            return redirect()->route('cms.dashboard');
        }

        return redirect()->route('cms.login');
    }

    public function create()
	{
        $user = UserModel::with(['role'])->whereHas('role', function($query) {
            $query->where('role_id', '>', 1);
        })->get();
        
        return view('pengadaan::perbaikan.create', ['user' => $user]);
	}

    public function store(Request $request)
    {        
        $post = $request->input();
        // dd($post);

        $validate = Validator::make($post, [
            'pemohon' => 'required',
            'tgl_pengajuan' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.perbaikan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $perbaikan = new PengadaanModel;
            $perbaikan->user_id = $post['pemohon'];
            // $perbaikan->jenis_pengajuan = 3;
            $perbaikan->status = $post['status'];
            $perbaikan->nomor_laporan = $post['nomor_laporan'];
            $perbaikan->pengajuan = $post['tgl_pengajuan'];
            // $perbaikan->approve_wakasek = 0;
            // $perbaikan->approve_kepsek = 0;
            $perbaikan->save();
            $id_pengajuan = $perbaikan->id;

            $perbaikan_history = new PengadaanHistoryModel;
            $perbaikan_history->pengadaan_id = $id_pengajuan;
            $perbaikan_history->jenis_pengajuan = 3;
            $perbaikan_history->approve_wakasek = 0;
            $perbaikan_history->approve_kepsek = 0;
            $perbaikan_history->save();

            if(isset($post['perbaikan'])) {
                foreach ($post['perbaikan'] as $key => $data_perbaikan) {
                    $item_perbaikan = new ItemPengadaanModel;
                    $item_perbaikan->pengadaan_id = $id_pengajuan;
                    $item_perbaikan->nama_barang = (isset($data_perbaikan['nama_barang'])) ? ucwords($data_perbaikan['nama_barang']) : '';
                    $item_perbaikan->spesifikasi_barang = (isset($data_perbaikan['spesifikasi_barang'])) ? $data_perbaikan['spesifikasi_barang'] : '';
                    $item_perbaikan->uraian_barang = (isset($data_perbaikan['uraian_barang'])) ? $data_perbaikan['uraian_barang'] : '';
                    $item_perbaikan->qty = (isset($data_perbaikan['qty'])) ? $data_perbaikan['qty'] : 0;
                    $item_perbaikan->satuan = (isset($data_perbaikan['satuan'])) ? $data_perbaikan['satuan'] : 0;
                    $item_perbaikan->keterangan = (isset($data_perbaikan['keterangan'])) ? $data_perbaikan['keterangan'] : '';
                    $item_perbaikan->status = 3;
                    $item_perbaikan->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.perbaikan.view');
        }
    }

    public function edit($id, Request $request)
    {        
        $perbaikan = PengadaanModel::with('item_pengadaan')->find($id);
        if(!$perbaikan){
            abort(404);
        }

        $user = UserModel::with(['role'])->whereHas('role', function($query) {
            $query->where('role_id', '>', 1);
        })->get();

        return view('pengadaan::perbaikan.edit', ['perbaikan'=>$perbaikan, 'user'=>$user]);
    }

    public function editByRole($id, Request $request)
    {        
        $user = Sentinel::check();
        if($user) {
            if($user->inRole('kepsek') || $user->inRole('wakasek')) {
                $pengadaan = PengadaanModel::with('item_pengadaan')->find($id);
                if(!$pengadaan){
                    abort(404);
                }

                $user = UserModel::with(['role'])->whereHas('role', function($query) {
                    $query->where('role_id', '>', 1);
                })->get();

                return view('pengadaan::perbaikan.editbyrole', ['pengadaan'=>$pengadaan, 'user'=>$user]);
            }
        }
        abort(404);
    }

    public function update(Request $request)
    {        
        $post = $request->input();
        $id = (int)$request->route('id');

        $validate = Validator::make($post, [
            'pemohon' => 'required',
            'tgl_pengajuan' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.perbaikan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $perbaikan = PengadaanModel::find($id);
            $perbaikan->user_id = $post['pemohon'];
            // $perbaikan->jenis_pengajuan = 3;
            $perbaikan->status = $post['status'];
            $perbaikan->nomor_laporan = $post['nomor_laporan'];
            $perbaikan->pengajuan = $post['tgl_pengajuan'];
            // $perbaikan->approve_wakasek = 0;
            // $perbaikan->approve_kepsek = 0;
            $perbaikan->save();
            $id_pengajuan = (int)$perbaikan->id;

            $perbaikan_history = PengadaanHistoryModel::where('jenis_pengajuan', 3)->where('pengadaan_id', $id_pengajuan)->first();
            $perbaikan_history->approve_wakasek = 0;
            $perbaikan_history->approve_kepsek = 0;
            $perbaikan_history->tgl_approve_wakasek = null;
            $perbaikan_history->tgl_approve_kepsek = null;
            $perbaikan_history->save();

            if(isset($post['perbaikan'])) {
                if(isset($post['item_data'])) {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->whereNotIn('id', $post['item_data'])->delete();
                } else {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->delete();
                }

                foreach ($post['perbaikan'] as $key => $data_perbaikan) {
                    var_dump($data_perbaikan['satuan']);
                    if(isset($data_perbaikan['item'])) {
                        $item_perbaikan = ItemPengadaanModel::find($data_perbaikan['item']);
                        $item_perbaikan->pengadaan_id = $id_pengajuan;
                        $item_perbaikan->nama_barang = (isset($data_perbaikan['nama_barang'])) ? ucwords($data_perbaikan['nama_barang']) : '';
                        $item_perbaikan->spesifikasi_barang = (isset($data_perbaikan['spesifikasi_barang'])) ? $data_perbaikan['spesifikasi_barang'] : '';
                        $item_perbaikan->uraian_barang = (isset($data_perbaikan['uraian_barang'])) ? $data_perbaikan['uraian_barang'] : '';
                        $item_perbaikan->qty = (isset($data_perbaikan['qty'])) ? $data_perbaikan['qty'] : '';
                        $item_perbaikan->satuan = (isset($data_perbaikan['satuan'])) ? $data_perbaikan['satuan'] : '';
                        $item_perbaikan->keterangan = (isset($data_perbaikan['keterangan'])) ? $data_perbaikan['keterangan'] : '';
                        $item_perbaikan->status = 3;
                        $item_perbaikan->save();
                    } else {
                        $item_perbaikan = new ItemPengadaanModel;
                        $item_perbaikan->pengadaan_id = $id_pengajuan;
                        $item_perbaikan->nama_barang = (isset($data_perbaikan['nama_barang'])) ? ucwords($data_perbaikan['nama_barang']) : '';
                        $item_perbaikan->spesifikasi_barang = (isset($data_perbaikan['spesifikasi_barang'])) ? $data_perbaikan['spesifikasi_barang'] : '';
                        $item_perbaikan->uraian_barang = (isset($data_perbaikan['uraian_barang'])) ? $data_perbaikan['uraian_barang'] : '';
                        $item_perbaikan->qty = (isset($data_perbaikan['qty'])) ? $data_perbaikan['qty'] : '';
                        $item_perbaikan->satuan = (isset($data_perbaikan['satuan'])) ? $data_perbaikan['satuan'] : '';
                        $item_perbaikan->keterangan = (isset($data_perbaikan['keterangan'])) ? $data_perbaikan['keterangan'] : '';
                        $item_perbaikan->status = 3;
                        $item_perbaikan->save();
                    }
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.perbaikan.view');
        }
    }
	
    public function list(Request $request)
    {
        $allGet = $request->all();
        $data = [];
        $countTable = 0;
        $headerCode = 200;
        $returnErrors = null;
        
        try{
            $columnIndex = $allGet['order'][0]['column'];
            $searchValue = $allGet['search']['value'];
            $startDate = $allGet['startDate'];
            $endDate = $allGet['endDate'];

            $pengadaanModel = PengadaanModel::query()->with(['related_history'])->whereHas('history', function($query) {
                $query->where('jenis_pengajuan', '=', 3);
            })->normalPengadaan();
            if($columnIndex == 0){
                $pengadaanModel->orderBy('pengadaan.id' , $allGet['order'][0]['dir']);
            }else{
                $pengadaanModel->orderBy( 'pengadaan.'.$allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            if($searchValue){
                $pengadaanModel->where('pengadaan.nomor_laporan', 'like', "%{$searchValue}%");
            }
            if($startDate && $endDate){
                $pengadaanModel->whereRaw('DATE(pengadaan.pengajuan) BETWEEN ? AND ?',[$startDate,$endDate]);
            }
            $countTable = $pengadaanModel->count();
            $preData = $pengadaanModel
                ->with(['user'])
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();
            $fractal = new Manager();
            $resource = new Collection($preData, new PengadaanTransformer());
            $dataT = $fractal->createData($resource)->toArray();
            $data = $dataT['data'];

        } catch(\Exception $e){
            $returnErrors = [ ['field'=>'database', 'message'=>'Internal Server Error '.$e->getMessage()] ];
            $headerCode = 500;
        }

        return response()->json(
            [
                'data' => $data,
                'draw' => $allGet['draw'],
                'recordsFiltered' => $countTable,
                'recordsTotal' => $countTable,
                'total_page' => ( (int) (20 / $allGet['length']) ),
                'old_start' => ((int) $allGet['start']),
                'errors' => $returnErrors,
            ],
            $headerCode
        );
    }

    public function show($id, Request $request)
    {        
        $user = Sentinel::check();
        if($user) {
            if($user->inRole('kepsek') || $user->inRole('wakasek') || $user->inRole('administrator') || $user->inRole('bendahara')) {
                $perbaikan = PengadaanModel::with(['item_pengadaan', 'user'])->find($id);
                if(!$perbaikan){
                    abort(404);
                }
                
                $btn = "admin";
                if($user->inRole('kepsek')) {
                    $btn = "kepsek";
                }

                if($user->inRole('wakasek')) {
                    $btn = "wakasek";
                }
                return view('pengadaan::perbaikan.view', ['perbaikan'=>$perbaikan, 'btn'=>$btn]);
            }
        }
        abort(404);
    }

    public function updateByRole(Request $request)
    {        
        $post = $request->input();
        $id = (int)$request->route('id');

        $validate = Validator::make($post, [
            'approval' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.perbaikan.list')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            // $pengadaan = PengadaanModel::find($id);
            $pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 3)->where('pengadaan_id', $id)->first();
            $user = Sentinel::check();
            if($user) {
                if($user->inRole('kepsek')) {
                    $pengadaan_history->approve_kepsek = 1;
                } else if($user->inRole('wakasek')) {
                    $pengadaan_history->approve_wakasek = 1;
                }
                $pengadaan_history->save();
                
                // after save, crene new milestone
                $approval_pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 3)->where('pengadaan_id', $id)->first();
                if($approval_pengadaan_history->approve_kepsek == 1 && $approval_pengadaan_history->approve_wakasek == 1) {
                    $ne_pengadaan_history = new PengadaanHistoryModel;
                    $ne_pengadaan_history->pengadaan_id = $id;
                    $ne_pengadaan_history->jenis_pengajuan = 3;
                    $ne_pengadaan_history->approve_wakasek = 1;
                    $ne_pengadaan_history->approve_kepsek = 1;
                    $ne_pengadaan_history->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.perbaikan.view');
        }
    }

    public function detail($id)
	{
        $pengadaan = PengadaanModel::where('id',$id)            
            ->first();
        if(!$pengadaan){
            abort(404);
        }
		return view('pengadaan::perbaikan.detail',[
            'pengadaan' => $pengadaan,
        ]);
    }

    public function delete($id, Request $request){
        $pengadaan = PengadaanModel::find($id);
        if(!$pengadaan){
            abort(404);
        }else{
            $pengadaan_item = ItemPengadaanModel::where('pengadaan_id', $id)->get();
            $pengadaan_item->each(function($item){
                $item->delete();
            });

            $pengadaan->delete();
            
            $request->session()->flash('message', __('Data berhasil dihapus'));
            return redirect()->route('cms.perbaikan.view');
        }
    }


    public function export(Request $request){
        ini_set('memory_limit','512M');
        $pengadaans = PengadaanModel::normalPengadaan()
            ->join('activations','activations.spesifikasi_barang','pengadaans.id')
            ->select(
                'email',
                'first_name as name',
                DB::raw("IF(activations.completed=1, 'active', 'inactive') as status"),
                DB::raw('DATE_ADD(pengadaans.created_at, INTERVAL 7 HOUR) as created')
            )
            ->get();
        
        return response()->json(
            [
                'data' => $pengadaans,                
            ],
            200
        );
    }
    
}
