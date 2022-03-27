<?php

namespace Cms\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Cms\User\Http\Models\UserModel;
use Cms\User\Transformers\UserTransformer;
use Cms\User\Http\Models\RoleModel;
use Sentinel;
use DB;
use Activation;

class UserController extends Controller
{		
	

	public function index()
	{
		return view('user::user.index');
	}

    public function prefix(Request $request){
        if(Sentinel::check()){
            return redirect()->route('cms.dashboard');
        }

        return redirect()->route('cms.login');
    }

    public function create()
	{
        $roles = RoleModel::filterRoleUser()->get();        

		return view('user::user.create', ['roles'=>$roles]);
	}

    public function edit($id, Request $request)
    {        
        $user = UserModel::with('role')->find($id);

        $activation = 0;
        if($user->activation && $user->activation->completed){
            $activation = 1;
        }
        if(!$user){
            abort(404);
        }
        
        $roles = RoleModel::filterRoleUser()->get();

        return view('user::user.edit', ['user'=>$user, 'roles'=>$roles, 'activation'=>$activation]);
    }

    public function editpasswd($id, Request $request)
    {        
        $user = UserModel::with('role')->find($id);        
        if(!$user){
            abort(404);
        }
        
        $roles = RoleModel::filterRoleUser()->get();

        return view('user::user.editpasswd', ['user'=>$user, 'roles'=>$roles]);
    }

    public function store(Request $request)
    {        
        $post = $request->input();
        // dd(isset($post['password']));

        $validate = Validator::make($post, [
            'email' => 'required|email|max:190|unique:users',
            'password' => [
                'required',
                'string',
                'min:5',            
                'regex:/[a-z]/',     
                'regex:/[A-Z]/',     
                'regex:/[0-9]/',     
                // 'regex:/[@$!%*#?&]/',
                'required_with:confirm_password',
                'same:confirm_password',
            ]
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.user.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $role = Sentinel::findRoleById($post['role']);
            if($role){
                $credentials = [
                    'email' => $post['email'],
                    'password' => $post['password'], //time(),
                    'full_name' => $post['name'],
                    'address' => $post['address'],
                    'gender' => $post['gender'],
                    'phone' => $post['phone'],
                ];
                $user = Sentinel::register($credentials);                    
                if($user){
                    $role->users()->attach($user);

                    if($post['status']==1) {
                        $activation = Activation::exists($user);
                        if($post['status']==1 && !$activation) {
                            $activation = Activation::create($user);
                            Activation::complete($user, $activation->code);
                        }
                    }
                    
                    $request->session()->flash('message', __('cms.create_success'));
                }
            }
            
            return redirect()->route('cms.user.view');
        }
    }

    public function update($id, Request $request)
    {
        $user = UserModel::with('role')->find($id);
        if(!$user){
            abort(404);
        }else{
            $post = $request->input();                    
        
            $validate = Validator::make($post, [
                'email' => [
                    'required',
                    'max:190',
                    Rule::unique('users')->ignore($user->id)
                ],
                'name' => 'required|min:2|max:190',
                'role' => 'required',
            ]);

            if ($validate->fails()) {
                $errors = $validate->messages();
                $post['error'] = $errors->all();

                return redirect()->route('cms.user.edit', ['id'=>$id])
                    ->withErrors($validate)
                    ->withInput($post);         
            } else {
                $user->email = $post['email'];
                $user->full_name = $post['name'];
                $user->address = $post['address'];
                $user->gender = $post['gender'];
                $user->phone = $post['phone'];
                $user->save();

                $activation = Activation::exists($user);
                if($post['status']==1 && !$activation) {
                    $activation = Activation::create($user);
                    Activation::complete($user, $activation->code);
                } else if($post['status']!=1) {
                    Activation::remove($user);
                }

                if(!isset($user->role->role_id)){
                    $role = Sentinel::findRoleById($post['role']);
                    $role->users()->attach($user);
                }else if($user->role->role_id != $post['role']){
                    // detach
                    $role = Sentinel::findRoleById($user->role->role_id);
                    $role->users()->detach($user);

                    // attach
                    $role2 = Sentinel::findRoleById($post['role']);
                    $role2->users()->attach($user);
                }                            

                $request->session()->flash('message', __('cms.update_success'));
                return redirect()->route('cms.user.view');
            }
        }        
    }

    public function updatepasswd($id, Request $request)
    {
        $user = UserModel::with('role')->find($id);
        if(!$user){
            abort(404);
        }else{
            $post = $request->input();                    
        
            $validate = Validator::make($post, [
                'password' => [
                    'required',
                    'string',
                    'min:5',            
                    'regex:/[a-z]/',     
                    'regex:/[A-Z]/',     
                    'regex:/[0-9]/',     
                    // 'regex:/[@$!%*#?&]/',
                    'required_with:confirm_password',
                    'same:confirm_password',
                ]
            ]);

            if ($validate->fails()) {
                $errors = $validate->messages();
                $post['error'] = $errors->all();

                return redirect()->route('cms.user.editpasswd', ['id'=>$id])
                    ->withErrors($validate)
                    ->withInput($post);         
            } else {
                $credentials = [
                    'password' => $post['password'],
                ];
                $user = Sentinel::update($user, $credentials);

                $request->session()->flash('message', __('cms.update_success'));
                return redirect()->route('cms.user.view');
            }
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

            $userModel = UserModel::query()->normalUser();
            if($columnIndex == 0){
                $userModel->orderBy('users.id' , $allGet['order'][0]['dir']);
            }else{
                $userModel->orderBy( 'users.'.$allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            if($searchValue){
                $userModel->where('users.name', 'like', "%{$searchValue}%");
            }
            if($startDate && $endDate){
                $userModel->whereRaw('DATE(users.created_at) BETWEEN ? AND ?',[$startDate,$endDate]);
            }
            $countTable = $userModel->count();
            $preData = $userModel
                ->with(['activation'])
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();
            $fractal = new Manager();
            $resource = new Collection($preData, new UserTransformer());
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
        $user = UserModel::where('id',$id)            
            ->first();
        if(!$user){
            abort(404);
        }
		return view('user::user.detail',[
            'user' => $user,
        ]);
    }

    public function delete($id, Request $request){
        $user = UserModel::find($id);
        if(!$user){
            abort(404);
        }else{
            $user->delete();
            $request->session()->flash('message', __('cms.delete_success'));
            return redirect()->route('cms.user.view');
        }
    }


    public function export(Request $request){
        ini_set('memory_limit','512M');
        $users = UserModel::normalUser()
            ->join('activations','activations.user_id','users.id')
            ->select(
                'email',
                'first_name as name',
                DB::raw("IF(activations.completed=1, 'active', 'inactive') as status"),
                DB::raw('DATE_ADD(users.created_at, INTERVAL 7 HOUR) as created')
            )
            ->get();
        
        return response()->json(
            [
                'data' => $users,                
            ],
            200
        );
    }
    
}
