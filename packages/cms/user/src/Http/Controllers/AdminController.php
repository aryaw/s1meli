<?php

namespace Cms\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use Validator;

use App\Http\Controllers\Controller;

use Sentinel;
use Activation;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Cms\User\Http\Models\UserModel;
use Cms\User\Http\Models\RoleModel;
use Cms\User\Transformers\AdminTransformer;
use Cms\User\Helpers\AdminHelper;

class AdminController extends Controller
{	

	public function index()
	{
		return view('user::admin.index');
	}

	public function create()
	{
        $roles = RoleModel::filterRole()->get();        

		return view('user::admin.create', ['roles'=>$roles]);
	}

    public function edit($id, Request $request)
    {        
        $user = UserModel::with('role')->find($id);        
        if(!$user){
            abort(404);
        }
        
        $roles = RoleModel::filterRole()->get();

        return view('user::admin.edit', ['user'=>$user, 'roles'=>$roles]);
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

            $userModel = UserModel::query()->adminUser();
            if($columnIndex == 0){
                $userModel->orderBy('id' , $allGet['order'][0]['dir']);
            }else{
                $userModel->orderBy( $allGet['columns'][$columnIndex]['data'] , $allGet['order'][0]['dir']);
            }
            if($searchValue){
                $userModel->where('users.name', 'like', "%{$searchValue}%");
            }
            if($startDate && $endDate){
                $userModel->whereRaw('DATE(users.created_at) BETWEEN ? AND ?',[$startDate,$endDate]);
            }
            $countTable = $userModel->count();
            $preData = $userModel                
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();
            $fractal = new Manager();
            $resource = new Collection($preData, new AdminTransformer());
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

    public function store(Request $request)
    {        
        $post = $request->input();                    
        
        $validate = Validator::make($post, [
            'email' => 'required|email|max:190|unique:users',
            'name' => 'required|min:2|max:190',
            'role' => 'required',
        ]);

        if ($validate->fails()) {
            $errors = $validate->messages();
            $post['error'] = $errors->all();

            return redirect()->route('cms.admin.create')
                ->withErrors($validate)
                ->withInput($post);
        } else {
            $role = Sentinel::findRoleById($post['role']);
            if($role){
                $credentials = [
                    'email' => $post['email'],
                    'password' => time(),
                    'name' => $post['name'],
                ];
                $user = Sentinel::register($credentials);                    
                if($user){
                    $role->users()->attach($user);
                    
                    // sentinel user activation
                    $activation = Activation::create($user);

                    // Send Email
                    $link = route('cms.admin.activate.form', ['code' => $activation->code]);
                    $emailData = [
                        'name' => $post['name'],
                        'link' => $link,
                    ];
                    Mail::send('emails.activate', $emailData, function ($message) use ($user)
                    {
                        $message->from(config('mail.from.address'), config('mail.from.name'))
                                ->subject('Activate Your Admin Account')
                                ->to($user->email);
                    });

                    $fail = Mail::failures();
                    if ($fail){
                        $request->session()->flash('error', $fail[0]);
                    }else{
                        $request->session()->flash('message', __('cms.create_success'));
                    }
                }
            }
            
            return redirect()->route('cms.admin.view');
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

                return redirect()->route('cms.admin.edit', ['id'=>$id])
                    ->withErrors($validate)
                    ->withInput($post);         
            } else {
                $user->email = $post['email'];
                $user->name = $post['name'];
                $user->save();

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
                return redirect()->route('cms.admin.view');
            }
        }        
    }
    
    public function delete($id, Request $request)
    {
        $user = UserModel::find($id);
        if(!$user){
            abort(404);
        }else{
            $user->delete();

            $request->session()->flash('message', __('cms.delete_success'));
            return redirect()->route('cms.admin.view');
        }
    }




    public function login()
    {
        return view('user::admin.login');
    }

    public function logout(Request $request){
        #Sentinel::logout();
        $request->session()->flush();
        return redirect()->route('cms.login');
    }

    public function doLogin(Request $request)
    {   
        $post = $request->input();
        $message = '';
        try{
            $credentials = [
                'email'    => $post['username'],
                'password' => $post['password'],
            ];
            
            if($auth = Sentinel::authenticate($credentials)){                
                if($auth->inRole('administrator')){
                    $role = $auth->roles()->first();
                    AdminHelper::setMenuSession($role);
                    return redirect()->route('cms.dashboard');
                }else{
                    Sentinel::logout();
                }
            }
            $message = __('cms.auth_failed');
        }catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e){
            $message = $e->getMessage();
        }catch(\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e){
            $message = $e->getMessage();
        }

        return redirect()
            ->route('cms.login')
            ->withInput()
            ->with(['message'=>$message]);                
    }

    public function forgotPasswordForm()
    {
        return view('user::admin.forgot_password');
    }

    public function activateForm($code, Request $request)
    {
        $message = $request->session()->get('message');;
        if(!$message){
            // sentinel set expired. do this.
            $activation = Activation::createModel()->where('code', $code)->first();

            if($activation){
                $user = Sentinel::findById($activation->user_id);
                if ($activation = Activation::completed($user)){
                    $message = __('cms.activation_already_active');
                }
            }else{
                $message = __('cms.activation_not_found');
            }
        }
        return view('user::admin.active', ['code'=>$code, 'message'=>$message]);                    
    }

    public function activateWithPassword($code, Request $request)
    {
        $activation = Activation::createModel()->where('code', $code)->first();
        $message = __('cms.activation_not_found');
        $post = $request->post();

        if($activation){
            $user = Sentinel::findById($activation->user_id);
            if ($activation = Activation::completed($user)){
                $message = __('cms.activation_already_active');
            }
            else{
                $validate = Validator::make(
                    $post,
                    [
                        'password' => 'required|min:6|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.{1,})(?=.*[0-9]).*$/|confirmed',
                        'password_confirmation' => 'required|same:password',
                    ]
                );

                if ($validate->fails()) {
                    $errors = $validate->messages();
                    $post['error'] = $errors->all();

                    return redirect()->route('cms.admin.activate.form', ['code'=>$code])
                        ->withErrors($validate)
                        ->with(['code'=>$code, 'message'=>$message])
                        ->withInput($post);
                } else {
                    // Activation not found or not completed
                    $activate = Activation::complete($user, $code);
                    $password = $post['password'];
                    Sentinel::update($user, array('password' => $password));

                    if($activate){                        
                        $message = __('cms.activation_success');
                    }else{
                        $message = __('cms.activation_failed');
                    }
                }
            }
        }

        return redirect()->route('cms.admin.activate.form', ['code'=>$code])
            ->with(['message'=>$message]);
    }



    public function toggleMenu(Request $request){
        $toggle = $request->input('toggle');    

        $request->session()->put('toggle-menu', ($toggle=='true') ? 'menu-pin' : 'menu-pin-false');

        return response()->json(
            [
                'toggle' => $toggle,
                'class' => (($toggle) ? 'menu-pin' : 'menu-pin-false')
            ],
            200
        );
    }
    
}
