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

class PenerimaanController extends Controller
{		
    private $uploadDir = 'public/nota/penerimaan';

	public function index()
	{
		$user = Sentinel::check();
        if($user) {
            $roles = $user->roles()->first()->slug;
            return view('pengadaan::penerimaan.index', ['roles' => $roles]);
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

        $no_laporan = PengadaanModel::get();
        
        return view('pengadaan::penerimaan.create', ['user' => $user, 'no_laporan' => $no_laporan]);
	}

    public function store(Request $request)
    {        
        $post = $request->all();
        // dd($post);

        $validate = Validator::make($post, [
            'pemohon' => 'required',
            'tgl_penerimaan' => 'required',
            'status' => 'required',
            'nota' => 'required|max:3020|mimetypes:'.config('app.constants.image_mime'),
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.penerimaan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $nota = '';
            $sub = strtotime(date('Y-m'));
            if($request->file('nota') && $request->file('nota')->isValid()) {
                $nota = $request->file('nota')->store("{$this->uploadDir}/{$sub}");
            }

            $penerimaan = new PengadaanModel;
            $penerimaan->user_id = $post['pemohon'];
            $penerimaan->actor = $post['actor'];
            // $penerimaan->jenis_pengajuan = 2;
            $penerimaan->status = $post['status'];
            $penerimaan->pengajuan = $post['tgl_penerimaan'];
            $penerimaan->nota = $nota;
            // $penerimaan->approve_wakasek = 1;
            // $penerimaan->approve_kepsek = 1;
            $penerimaan->save();
            $id_pengajuan = $penerimaan->id;

            $penerimaan_history = new PengadaanHistoryModel;
            $penerimaan_history->pengadaan_id = $id_pengajuan;
            $penerimaan_history->jenis_pengajuan = 2;
            $penerimaan_history->approve_wakasek = 0;
            $penerimaan_history->approve_kepsek = 0;
            $penerimaan_history->save();

            if(isset($post['penerimaan'])) {
                foreach ($post['penerimaan'] as $key => $data_penerimaan) {
                    $item_penerimaan = new ItemPengadaanModel;
                    $item_penerimaan->pengadaan_id = $id_pengajuan;
                    $item_penerimaan->nama_barang = (isset($data_penerimaan['nama_barang'])) ? ucwords($data_penerimaan['nama_barang']) : '';
                    $item_penerimaan->spesifikasi_barang = (isset($data_penerimaan['spesifikasi_barang'])) ? $data_penerimaan['spesifikasi_barang'] : '';
                    $item_penerimaan->uraian_barang = (isset($data_penerimaan['uraian_barang'])) ? $data_penerimaan['uraian_barang'] : '';
                    $item_penerimaan->qty = (isset($data_penerimaan['qty'])) ? $data_penerimaan['qty'] : 0;
                    $item_penerimaan->keterangan = (isset($data_penerimaan['keterangan'])) ? $data_penerimaan['keterangan'] : '';
                    $item_penerimaan->status = 2;
                    $item_penerimaan->save();
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.penerimaan.view');
        }
    }

    public function edit($id, Request $request)
    {        
        $penerimaan = PengadaanModel::with('item_pengadaan')->find($id);
        if(!$penerimaan){
            abort(404);
        }

        $user = UserModel::with(['role'])->whereHas('role', function($query) {
            $query->where('role_id', '>', 1);
        })->get();

        $no_laporan = PengadaanModel::get();

        return view('pengadaan::penerimaan.edit', ['penerimaan'=>$penerimaan, 'user'=>$user, 'no_laporan' => $no_laporan]);
    }

    public function show($id, Request $request)
    {        
        $user = Sentinel::check();
        if($user) {
            if($user->inRole('kepsek') || $user->inRole('wakasek') || $user->inRole('administrator') || $user->inRole('bendahara')) {
                $penerimaan = PengadaanModel::with(['item_pengadaan', 'user'])->find($id);
                if(!$penerimaan){
                    abort(404);
                }
                
                $btn = "admin";
                if($user->inRole('kepsek')) {
                    $btn = "kepsek";
                }

                if($user->inRole('wakasek')) {
                    $btn = "wakasek";
                }
                return view('pengadaan::penerimaan.view', ['penerimaan'=>$penerimaan, 'btn'=>$btn]);
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
            'tgl_penerimaan' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.penerimaan.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $penerimaan = PengadaanModel::find($id);
            $penerimaan->user_id = $post['pemohon'];
            $penerimaan->actor = $post['actor'];
            // $penerimaan->jenis_pengajuan = 2;
            $penerimaan->status = $post['status'];
            $penerimaan->pengajuan = $post['tgl_penerimaan'];
            // $penerimaan->approve_wakasek = 0;
            // $penerimaan->approve_kepsek = 0;
            $penerimaan->save();
            $id_pengajuan = (int)$penerimaan->id;

            $penerimaan_history = PengadaanHistoryModel::where('jenis_pengajuan', 2)->where('pengadaan_id', $id_pengajuan)->first();
            $penerimaan_history->approve_wakasek = 0;
            $penerimaan_history->approve_kepsek = 0;
            $penerimaan_history->tgl_approve_wakasek = null;
            $penerimaan_history->tgl_approve_kepsek = null;
            $penerimaan_history->save();

            if(isset($post['penerimaan'])) {
                if(isset($post['item_data'])) {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->whereNotIn('id', $post['item_data'])->delete();
                } else {
                    ItemPengadaanModel::where('pengadaan_id', $id_pengajuan)->delete();
                }

                foreach ($post['penerimaan'] as $key => $data_penerimaan) {
                    if(isset($data_penerimaan['item'])) {
                        $item_penerimaan = ItemPengadaanModel::find($data_penerimaan['item']);
                        $item_penerimaan->pengadaan_id = $id_pengajuan;
                        $item_penerimaan->nama_barang = (isset($data_penerimaan['nama_barang'])) ? ucwords($data_penerimaan['nama_barang']) : '';
                        $item_penerimaan->spesifikasi_barang = (isset($data_penerimaan['spesifikasi_barang'])) ? $data_penerimaan['spesifikasi_barang'] : '';
                        $item_penerimaan->uraian_barang = (isset($data_penerimaan['uraian_barang'])) ? $data_penerimaan['uraian_barang'] : '';
                        $item_penerimaan->qty = (isset($data_penerimaan['qty'])) ? $data_penerimaan['qty'] : '';
                        $item_penerimaan->keterangan = (isset($data_penerimaan['keterangan'])) ? $data_penerimaan['keterangan'] : '';
                        $item_penerimaan->status = 2;
                        $item_penerimaan->save();
                    } else {
                        $item_penerimaan = new ItemPengadaanModel;
                        $item_penerimaan->pengadaan_id = $id_pengajuan;
                        $item_penerimaan->nama_barang = (isset($data_penerimaan['nama_barang'])) ? ucwords($data_penerimaan['nama_barang']) : '';
                        $item_penerimaan->spesifikasi_barang = (isset($data_penerimaan['spesifikasi_barang'])) ? $data_penerimaan['spesifikasi_barang'] : '';
                        $item_penerimaan->uraian_barang = (isset($data_penerimaan['uraian_barang'])) ? $data_penerimaan['uraian_barang'] : '';
                        $item_penerimaan->qty = (isset($data_penerimaan['qty'])) ? $data_penerimaan['qty'] : '';
                        $item_penerimaan->keterangan = (isset($data_penerimaan['keterangan'])) ? $data_penerimaan['keterangan'] : '';
                        $item_penerimaan->status = 2;
                        $item_penerimaan->save();
                    }
                }
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.penerimaan.view');
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

            return redirect()->route('cms.penerimaan.list')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $penerimaan = PengadaanModel::find($id);
            $user = Sentinel::check();
            if($user) {
                if($user->inRole('kepsek')) {
                    $penerimaan->approve_kepsek = 1;
                } else if($user->inRole('wakasek')) {
                    $penerimaan->approve_wakasek = 1;
                }
                $penerimaan->save();
            }

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.penerimaan.view');
        }
    }

    public function editNota($id, Request $request)
    {        
        $penerimaan = PengadaanModel::with(['item_pengadaan', 'user'])->find($id);
        
        if(!$penerimaan){
            abort(404);
        }

        return view('pengadaan::penerimaan.editnota', ['penerimaan'=>$penerimaan]);
    }

    public function updateNota(Request $request)
    {        
        $post = $request->input();
        $id = (int)$request->route('id');

        $penerimaan = PengadaanModel::find($id);

        $validate = Validator::make($post, [
            'nota' => 'max:3020|mimetypes:'.config('app.constants.image_mime'),
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.penerimaan.editnota', ['id'=>$id])
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $nota = '';
            $sub = strtotime(date('Y-m'));
            if($request->file('nota') && $request->file('nota')->isValid()) {
                $nota = $request->file('nota')->store("{$this->uploadDir}/{$sub}");
            }

            $penerimaan->nota = $nota;
            $penerimaan->save();

            $request->session()->flash('message', __('Data berhasil disimpan'));            
            return redirect()->route('cms.penerimaan.view');
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
                $query->where('jenis_pengajuan', '=', 2);
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

    public function detail($id)
	{
        $pengadaan = PengadaanModel::where('id',$id)            
            ->first();
        if(!$pengadaan){
            abort(404);
        }
		return view('pengadaan::penerimaan.detail',[
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
            return redirect()->route('cms.penerimaan.view');
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
