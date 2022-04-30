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

class PengadaanController extends Controller
{		
	

	public function index()
	{
		$user = Sentinel::check();
        if($user) {
            $roles = $user->roles()->first()->slug;
            return view('pengadaan::pengadaan.index', ['roles' => $roles]);
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
        
        return view('pengadaan::pengadaan.create', ['user' => $user]);
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

            return redirect()->route('cms.pengadaan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $pengadaan = new PengadaanModel;
            $pengadaan->user_id = $post['pemohon'];
            // $pengadaan->jenis_pengajuan = 1;
            $pengadaan->nomor_laporan = $post['nomor_laporan'];
            $pengadaan->status = $post['status'];
            $pengadaan->pengajuan = $post['tgl_pengajuan'];
            // $pengadaan->approve_wakasek = 0;
            // $pengadaan->approve_kepsek = 0;
            $pengadaan->save();
            $id_pengajuan = $pengadaan->id;

            $pengadaan_history = new PengadaanHistoryModel;
            $pengadaan_history->pengadaan_id = $id_pengajuan;
            $pengadaan_history->jenis_pengajuan = 1;
            $pengadaan_history->approve_wakasek = 0;
            $pengadaan_history->approve_kepsek = 0;
            $pengadaan_history->save();

            if(isset($post['pengadaan'])) {
                foreach ($post['pengadaan'] as $key => $data_pengadaan) {
                    $item_pengadaan = new ItemPengadaanModel;
                    $item_pengadaan->pengadaan_id = $id_pengajuan;
                    $item_pengadaan->nama_barang = (isset($data_pengadaan['nama_barang'])) ? ucwords($data_pengadaan['nama_barang']) : '';
                    $item_pengadaan->spesifikasi_barang = (isset($data_pengadaan['spesifikasi_barang'])) ? $data_pengadaan['spesifikasi_barang'] : '';
                    $item_pengadaan->uraian_barang = (isset($data_pengadaan['uraian_barang'])) ? $data_pengadaan['uraian_barang'] : '';
                    $item_pengadaan->qty = (isset($data_pengadaan['qty'])) ? $data_pengadaan['qty'] : 0;
                    $item_pengadaan->keterangan = (isset($data_pengadaan['keterangan'])) ? $data_pengadaan['keterangan'] : '';
                    $item_pengadaan->status = 1;
                    $item_pengadaan->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.pengadaan.view');
        }
    }

    public function edit($id, Request $request)
    {        
        $pengadaan = PengadaanModel::with('item_pengadaan')->find($id);
        if(!$pengadaan){
            abort(404);
        }

        $user = UserModel::with(['role'])->whereHas('role', function($query) {
            $query->where('role_id', '>', 1);
        })->get();

        return view('pengadaan::pengadaan.edit', ['pengadaan'=>$pengadaan, 'user'=>$user]);
    }

    public function show($id, Request $request)
    {        
        $user = Sentinel::check();
        if($user) {
            if($user->inRole('kepsek') || $user->inRole('wakasek') || $user->inRole('administrator')) {
                $pengadaan = PengadaanModel::with(['item_pengadaan', 'user'])->find($id);
                if(!$pengadaan){
                    abort(404);
                }
                
                $btn = "admin";
                if($user->inRole('kepsek')) {
                    $btn = "kepsek";
                }

                if($user->inRole('wakasek')) {
                    $btn = "wakasek";
                }
                return view('pengadaan::pengadaan.view', ['pengadaan'=>$pengadaan, 'btn'=>$btn]);
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

            return redirect()->route('cms.pengadaan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $pengadaan = PengadaanModel::find($id);
            $pengadaan->user_id = $post['pemohon'];
            // $pengadaan->jenis_pengajuan = 1;
            $pengadaan->status = $post['status'];
            $pengadaan->nomor_laporan = $post['nomor_laporan'];
            $pengadaan->pengajuan = $post['tgl_pengajuan'];
            // $pengadaan->approve_wakasek = 0;
            // $pengadaan->approve_kepsek = 0;
            $pengadaan->save();
            $id_pengajuan = (int)$pengadaan->id;

            $pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 1)->where('pengadaan_id', $id_pengajuan)->first();
            $pengadaan_history->approve_wakasek = 0;
            $pengadaan_history->approve_kepsek = 0;
            $pengadaan_history->tgl_approve_wakasek = null;
            $pengadaan_history->tgl_approve_kepsek = null;
            $pengadaan_history->save();

            if(isset($post['pengadaan'])) {
                if(isset($post['item_data'])) {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->whereNotIn('id', $post['item_data'])->delete();
                } else {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->delete();
                }

                foreach ($post['pengadaan'] as $key => $data_pengadaan) {
                    if(isset($data_pengadaan['item'])) {
                        $item_pengadaan = ItemPengadaanModel::find($data_pengadaan['item']);
                        $item_pengadaan->pengadaan_id = $id_pengajuan;
                        $item_pengadaan->nama_barang = (isset($data_pengadaan['nama_barang'])) ? ucwords($data_pengadaan['nama_barang']) : '';
                        $item_pengadaan->spesifikasi_barang = (isset($data_pengadaan['spesifikasi_barang'])) ? $data_pengadaan['spesifikasi_barang'] : '';
                        $item_pengadaan->uraian_barang = (isset($data_pengadaan['uraian_barang'])) ? $data_pengadaan['uraian_barang'] : '';
                        $item_pengadaan->qty = (isset($data_pengadaan['qty'])) ? $data_pengadaan['qty'] : '';
                        $item_pengadaan->keterangan = (isset($data_pengadaan['keterangan'])) ? $data_pengadaan['keterangan'] : '';
                        $item_pengadaan->status = 1;
                        $item_pengadaan->save();
                    } else {
                        $item_pengadaan = new ItemPengadaanModel;
                        $item_pengadaan->pengadaan_id = $id_pengajuan;
                        $item_pengadaan->nama_barang = (isset($data_pengadaan['nama_barang'])) ? ucwords($data_pengadaan['nama_barang']) : '';
                        $item_pengadaan->spesifikasi_barang = (isset($data_pengadaan['spesifikasi_barang'])) ? $data_pengadaan['spesifikasi_barang'] : '';
                        $item_pengadaan->uraian_barang = (isset($data_pengadaan['uraian_barang'])) ? $data_pengadaan['uraian_barang'] : '';
                        $item_pengadaan->qty = (isset($data_pengadaan['qty'])) ? $data_pengadaan['qty'] : '';
                        $item_pengadaan->keterangan = (isset($data_pengadaan['keterangan'])) ? $data_pengadaan['keterangan'] : '';
                        $item_pengadaan->status = 1;
                        $item_pengadaan->save();
                    }
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.pengadaan.view');
        }
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

            return redirect()->route('cms.pengadaan.list')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            // $pengadaan = PengadaanModel::find($id);
            $pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 1)->where('pengadaan_id', $id)->first();
            $user = Sentinel::check();
            if($user) {
                if($user->inRole('kepsek')) {
                    $pengadaan_history->approve_kepsek = 1;
                } else if($user->inRole('wakasek')) {
                    $pengadaan_history->approve_wakasek = 1;
                }
                $pengadaan_history->save();
                
                // after save, crene new milestone
                $approval_pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 1)->where('pengadaan_id', $id)->first();
                if($approval_pengadaan_history->approve_kepsek == 1 && $approval_pengadaan_history->approve_wakasek == 1) {
                    $ne_pengadaan_history = new PengadaanHistoryModel;
                    $ne_pengadaan_history->pengadaan_id = $id;
                    $ne_pengadaan_history->jenis_pengajuan = 2;
                    $ne_pengadaan_history->approve_wakasek = 1;
                    $ne_pengadaan_history->approve_kepsek = 1;
                    $ne_pengadaan_history->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.pengadaan.view');
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
                $query->where('jenis_pengajuan', '=', 1);
            })->normalPengadaan();
            if($columnIndex == 0){
                $pengadaanModel->orderBy('pengadaan.id' , $allGet['order'][0]['dir']);
            }else{
                $pengadaanModel->orderBy( 'pengadaan.'.$allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            // if($searchValue){
            //     $pengadaanModel->where('pengadaan.name', 'like', "%{$searchValue}%");
            // }
            if($startDate && $endDate){
                $pengadaanModel->whereRaw('DATE(pengadaan.created_at) BETWEEN ? AND ?',[$startDate,$endDate]);
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

    public function detail($id)
	{
        $pengadaan = PengadaanModel::where('id',$id)            
            ->first();
        if(!$pengadaan){
            abort(404);
        }
		return view('pengadaan::pengadaan.detail',[
            'pengadaan' => $pengadaan,
        ]);
    }

    public function delete($id, Request $request){
        $pengadaan = PengadaanModel::find($id);
        if(!$pengadaan){
            abort(404);
        }else{
            $pengadaan->delete();
            $request->session()->flash('message', __('Data berhasil dihapus'));
            return redirect()->route('cms.pengadaan.view');
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
