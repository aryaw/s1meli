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

class KerusakanController extends Controller
{		
	

	public function index()
	{
		$user = Sentinel::check();
        if($user) {
            $roles = $user->roles()->first()->slug;
            return view('pengadaan::kerusakan.index', ['roles' => $roles]);
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
        
        return view('pengadaan::kerusakan.create', ['user' => $user]);
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

            return redirect()->route('cms.kerusakan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $kerusakan = new PengadaanModel;
            $kerusakan->user_id = $post['pemohon'];
            // $kerusakan->jenis_pengajuan = 4;
            $kerusakan->status = $post['status'];
            $kerusakan->nomor_laporan = $post['nomor_laporan'];
            $kerusakan->pengajuan = $post['tgl_pengajuan'];
            // $kerusakan->approve_wakasek = 0;
            // $kerusakan->approve_kepsek = 0;
            $kerusakan->save();
            $id_pengajuan = $kerusakan->id;

            $kerusakan_history = new PengadaanHistoryModel;
            $kerusakan_history->pengadaan_id = $id_pengajuan;
            $kerusakan_history->jenis_pengajuan = 4;
            $kerusakan_history->approve_wakasek = 0;
            $kerusakan_history->approve_kepsek = 0;
            $kerusakan_history->save();

            if(isset($post['kerusakan'])) {
                foreach ($post['kerusakan'] as $key => $data_kerusakan) {
                    $item_kerusakan = new ItemPengadaanModel;
                    $item_kerusakan->pengadaan_id = $id_pengajuan;
                    $item_kerusakan->nama_barang = (isset($data_kerusakan['nama_barang'])) ? ucwords($data_kerusakan['nama_barang']) : '';
                    $item_kerusakan->spesifikasi_barang = (isset($data_kerusakan['spesifikasi_barang'])) ? $data_kerusakan['spesifikasi_barang'] : '';
                    $item_kerusakan->uraian_barang = (isset($data_kerusakan['uraian_barang'])) ? $data_kerusakan['uraian_barang'] : '';
                    $item_kerusakan->qty = (isset($data_kerusakan['qty'])) ? $data_kerusakan['qty'] : 0;
                    $item_kerusakan->satuan = (isset($data_kerusakan['satuan'])) ? $data_kerusakan['satuan'] : 0;
                    $item_kerusakan->keterangan = (isset($data_kerusakan['keterangan'])) ? $data_kerusakan['keterangan'] : '';
                    $item_kerusakan->status = 4;
                    $item_kerusakan->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.kerusakan.view');
        }
    }

    public function edit($id, Request $request)
    {        
        $kerusakan = PengadaanModel::with('item_pengadaan')->find($id);
        if(!$kerusakan){
            abort(404);
        }

        $user = UserModel::with(['role'])->whereHas('role', function($query) {
            $query->where('role_id', '>', 1);
        })->get();

        return view('pengadaan::kerusakan.edit', ['kerusakan'=>$kerusakan, 'user'=>$user]);
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

                return view('pengadaan::kerusakan.editbyrole', ['pengadaan'=>$pengadaan, 'user'=>$user]);
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

            return redirect()->route('cms.kerusakan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $kerusakan = PengadaanModel::find($id);
            $kerusakan->user_id = $post['pemohon'];
            // $kerusakan->jenis_pengajuan = 4;
            $kerusakan->status = $post['status'];
            $kerusakan->nomor_laporan = $post['nomor_laporan'];
            $kerusakan->pengajuan = $post['tgl_pengajuan'];
            // $kerusakan->approve_wakasek = 0;
            // $kerusakan->approve_kepsek = 0;
            $kerusakan->save();
            $id_pengajuan = (int)$kerusakan->id;

            $kerusakan_history = PengadaanHistoryModel::where('jenis_pengajuan', 4)->where('pengadaan_id', $id_pengajuan)->first();
            $kerusakan_history->approve_wakasek = 0;
            $kerusakan_history->approve_kepsek = 0;
            $kerusakan_history->tgl_approve_wakasek = null;
            $kerusakan_history->tgl_approve_kepsek = null;
            $kerusakan_history->save();

            if(isset($post['kerusakan'])) {
                if(isset($post['item_data'])) {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->whereNotIn('id', $post['item_data'])->delete();
                } else {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->delete();
                }

                foreach ($post['kerusakan'] as $key => $data_kerusakan) {
                    if(isset($data_kerusakan['item'])) {
                        $item_kerusakan = ItemPengadaanModel::find($data_kerusakan['item']);
                        $item_kerusakan->pengadaan_id = $id_pengajuan;
                        $item_kerusakan->nama_barang = (isset($data_kerusakan['nama_barang'])) ? ucwords($data_kerusakan['nama_barang']) : '';
                        $item_kerusakan->spesifikasi_barang = (isset($data_kerusakan['spesifikasi_barang'])) ? $data_kerusakan['spesifikasi_barang'] : '';
                        $item_kerusakan->uraian_barang = (isset($data_kerusakan['uraian_barang'])) ? $data_kerusakan['uraian_barang'] : '';
                        $item_kerusakan->qty = (isset($data_kerusakan['qty'])) ? $data_kerusakan['qty'] : '';
                        $item_kerusakan->satuan = (isset($data_kerusakan['satuan'])) ? $data_kerusakan['satuan'] : '';
                        $item_kerusakan->keterangan = (isset($data_kerusakan['keterangan'])) ? $data_kerusakan['keterangan'] : '';
                        $item_kerusakan->status = 4;
                        $item_kerusakan->save();
                    } else {
                        $item_kerusakan = new ItemPengadaanModel;
                        $item_kerusakan->pengadaan_id = $id_pengajuan;
                        $item_kerusakan->nama_barang = (isset($data_kerusakan['nama_barang'])) ? ucwords($data_kerusakan['nama_barang']) : '';
                        $item_kerusakan->spesifikasi_barang = (isset($data_kerusakan['spesifikasi_barang'])) ? $data_kerusakan['spesifikasi_barang'] : '';
                        $item_kerusakan->uraian_barang = (isset($data_kerusakan['uraian_barang'])) ? $data_kerusakan['uraian_barang'] : '';
                        $item_kerusakan->qty = (isset($data_kerusakan['qty'])) ? $data_kerusakan['qty'] : '';
                        $item_kerusakan->satuan = (isset($data_kerusakan['satuan'])) ? $data_kerusakan['satuan'] : '';
                        $item_kerusakan->keterangan = (isset($data_kerusakan['keterangan'])) ? $data_kerusakan['keterangan'] : '';
                        $item_kerusakan->status = 4;
                        $item_kerusakan->save();
                    }
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.kerusakan.view');
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
                $query->where('jenis_pengajuan', '=', 4);
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
                // $kerusakan = PengadaanModel::with(['item_pengadaan', 'user'])->find($id);
                $kerusakan = PengadaanModel::query()->with(['related_history','item_pengadaan', 'user'])->whereHas('history', function($query) {
                    $query->where('jenis_pengajuan', '=', 3);
                })->find($id);
                if(!$kerusakan){
                    abort(404);
                }
                
                $btn = "admin";
                if($user->inRole('kepsek')) {
                    $btn = "kepsek";
                }

                if($user->inRole('wakasek')) {
                    $btn = "wakasek";
                }
                return view('pengadaan::kerusakan.view', ['kerusakan'=>$kerusakan, 'btn'=>$btn]);
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

            return redirect()->route('cms.kerusakan.list')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            // $pengadaan = PengadaanModel::find($id);
            $pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 4)->where('pengadaan_id', $id)->first();
            $user = Sentinel::check();
            if($user) {
                if($user->inRole('kepsek')) {
                    $pengadaan_history->approve_kepsek = 1;
                } else if($user->inRole('wakasek')) {
                    $pengadaan_history->approve_wakasek = 1;
                }
                $pengadaan_history->save();
                
                // after save, crene new milestone
                $approval_pengadaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 4)->where('pengadaan_id', $id)->first();
                if($approval_pengadaan_history->approve_kepsek == 1 && $approval_pengadaan_history->approve_wakasek == 1) {
                    $ne_pengadaan_history = new PengadaanHistoryModel;
                    $ne_pengadaan_history->pengadaan_id = $id;
                    $ne_pengadaan_history->jenis_pengajuan = 4;
                    $ne_pengadaan_history->approve_wakasek = 1;
                    $ne_pengadaan_history->approve_kepsek = 1;
                    $ne_pengadaan_history->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.kerusakan.view');
        }
    }

    public function detail($id)
	{
        $pengadaan = PengadaanModel::where('id',$id)            
            ->first();
        if(!$pengadaan){
            abort(404);
        }
		return view('pengadaan::kerusakan.detail',[
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
            return redirect()->route('cms.kerusakan.view');
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
