<?php

namespace Cms\Pengadaan\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Cms\Pengadaan\Http\Models\BarangModel;
use Cms\Pengadaan\Transformers\BarangTransformer;
use DB;
use Cms\User\Http\Models\UserModel;
use Sentinel;

class BarangController extends Controller
{		
	

	public function index()
	{
		$user = Sentinel::check();
        if($user) {
            return view('pengadaan::barang.index');
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
        return view('pengadaan::barang.create');
	}

    public function store(Request $request)
    {        
        $post = $request->input();

        $validate = Validator::make($post, [
            'kode_barang' => 'required',
            'nama' => 'required',
            'kategory' => 'required',
            'merk' => 'required',
            'bahan' => 'required',
            'spesifikasi' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.barang.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $barang = new BarangModel;
            $barang->kode_barang = $post['kode_barang'];
            $barang->nama = $post['nama'];
            $barang->kategory = $post['kategory'];
            $barang->merk = $post['merk'];
            $barang->bahan = $post['bahan'];
            $barang->spesifikasi = $post['spesifikasi'];
            $barang->status = $post['status'];
            $barang->save();

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.barang.view');
        }
    }

    public function edit($id, Request $request)
    {        
        $barang = BarangModel::find($id);
        if(!$barang){
            abort(404);
        }

        return view('pengadaan::barang.edit', ['barang'=>$barang]);
    }

    public function update(Request $request)
    {        
        $post = $request->input();
        $id = (int)$request->route('id');

        $validate = Validator::make($post, [
            'kode_barang' => 'required',
            'nama' => 'required',
            'kategory' => 'required',
            'merk' => 'required',
            'bahan' => 'required',
            'spesifikasi' => 'required',
            'status' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.barang.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $barang = BarangModel::find($id);
            $barang->kode_barang = $post['kode_barang'];
            $barang->nama = $post['nama'];
            $barang->kategory = $post['kategory'];
            $barang->merk = $post['merk'];
            $barang->bahan = $post['bahan'];
            $barang->spesifikasi = $post['spesifikasi'];
            $barang->status = $post['status'];
            $barang->save();

            $request->session()->flash('message', __('Data berhasil disimpan'));
            
            return redirect()->route('cms.barang.view');
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

            $barangModel = BarangModel::query()->normalBarang();
            if($columnIndex == 0){
                $barangModel->orderBy('barang.id' , $allGet['order'][0]['dir']);
            }else{
                $barangModel->orderBy( 'barang.'.$allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            if($searchValue){
                $barangModel->where('barang.nama', 'like', "%{$searchValue}%");
            }
            $countTable = $barangModel->count();
            $preData = $barangModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();
            $fractal = new Manager();
            $resource = new Collection($preData, new BarangTransformer());
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

    public function delete($id, Request $request){
        $barnag = BarangModel::find($id);
        if(!$barnag){
            abort(404);
        }else{
            $barnag->delete();
            
            $request->session()->flash('message', __('Data berhasil dihapus'));
            return redirect()->route('cms.barang.view');
        }
    }
    
}
