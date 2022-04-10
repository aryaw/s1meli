<?php

namespace Cms\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Http\Controllers\Controller;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Cms\User\Http\Models\RoleModel;
use Cms\User\Transformers\RoleTransformer;

class RoleController extends Controller
{		

	public function index()
	{
		$roles = [];

		return view('user::role.index', ['roles'=>$roles]);
	}

	public function create()
	{
		return view('user::role.create');
	}

	public function edit($id, Request $request)
	{
		
		$role = RoleModel::find($id);
		if(!$role){
			abort(404);
		}
		return view('user::role.edit', ['role'=>$role]);
	}

	public function list(Request $request){
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

        	$roleModel = RoleModel::query();
            if($columnIndex == 0){
                $roleModel->orderBy('id' , $allGet['order'][0]['dir']);
            }else{
                $roleModel->orderBy( $allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            if($searchValue){
                $roleModel->where('name', 'like', "%{$searchValue}%");
            }
            if($startDate && $endDate){
                $roleModel->whereRaw('DATE(created_at) BETWEEN ? AND ?',[$startDate,$endDate]);
            }
        	$countTable = $roleModel->count();
            $preData = $roleModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $fractal = new Manager();
            $resource = new Collection($preData, new RoleTransformer());
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

	public function store(Request $request){		
        $post = $request->input();                    
        
        $validate = Validator::make($post, [
            'slug' => 'required|max:190|unique:roles',
            'name' => 'required|max:190',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.role.create')
                ->withErrors($validate)
                ->withInput($post);        	
        } else {
        	RoleModel::create([
        		'slug' => $post['slug'],
                'name' => $post['name']             
        	]);
            $request->session()->flash('message', __('Data berhasil disimpan'));
            return redirect()->route('cms.role.view');
        }
	}

	public function update($id, Request $request){
        $role = RoleModel::find($id);
        if(!$role){
            abort(404);
        }else{
            $post = $request->input();                    
        
            $validate = Validator::make($post, [
                'slug' => [
                    'required',
                    'max:190',
                    Rule::unique('roles')->ignore($role->id)
                ],
                'name' => 'required|max:190',
            ]);

            if ($validate->fails()) {
                $errors = $validate->messages();
                $post['error'] = $errors->all();

                return redirect()->route('cms.role.edit', ['id'=>$id])
                    ->withErrors($validate)
                    ->withInput($post);         
            } else {
                $role->slug = $post['slug'];
                $role->name = $post['name'];
                $role->save();

                $request->session()->flash('message', __('cms.update_success'));
                return redirect()->route('cms.role.view');
            }
        }        
	}
    
    public function delete($id, Request $request){
        $role = RoleModel::find($id);
        if(!$role){
            abort(404);
        }else{
            $role->delete();

            $request->session()->flash('message', __('Data berhasil dihapus'));
            return redirect()->route('cms.role.view');
        }
    }
}
