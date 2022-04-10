<?php

namespace Cms\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Cms\User\Http\Models\RoleModel;
use Cms\User\Helpers\AdminHelper;

class RoleManagementController extends Controller
{		

	public function index()
	{
		$permissions = [];
		$permissionConfig = config('app.permission');
        $roles = RoleModel::whereIn('slug', ['administrator', 'admin', 'kepsek', 'wakasek'])
            ->get();
		$gg = [];

		$n = 0;
        foreach($permissionConfig as $permission){
            $apa = [];
            foreach($roles as $role){
                $fullOfPermissions = (array) json_decode($role['permissions']);
                $checked = false;
                if( isset($fullOfPermissions[$permission['code']]) && $fullOfPermissions[$permission['code']]){
                    $checked = true;
                    
                    // parent checked condition
                    $gg[$permission['parent'].'_'.$role['slug']] = [
                        'parent'=>$permission['parent'], 
                        'role'=>$role['slug']
                    ];
                }
                $apa[] = [
                    'slug' => $role['slug'],
                    'name' => $role['name'],
                    'checked' => $checked,
                ];

                $permissions[$n] = $permission + ['roles'=>$apa];
            }
            $n++;
        }        

        // parent checked condition
        if($gg){
            foreach($permissions as $index=>$ppp){                
                if($ppp['parent'] == '0'){                    
                    foreach($ppp['roles'] as $indexNull=>$roleNull){
                        if(isset($gg[$ppp['code'].'_'.$roleNull['slug']])){                            
                            $roleNull['checked'] = true;
                            $permissions[$index]['roles'][$indexNull]['checked'] = true;                            
                        }
                    }                    
                }
            }
        }

        #dd($permissions);

		return view('user::rolemanagement.index', ['roles'=>$roles, 'permissions'=>$permissions]);
	}    

	public function store(Request $request){
        $posts = $request->except(['_token']);        
        $transforms = [
            'view' => 'list',
            'create' => 'store',
            'edit' => 'update',
        ];

        foreach($posts as $k=>$v){
            $role = RoleModel::where('slug', $k)->first();
            if($role){
                $v['cms.dashboard'] = true;                
                foreach($v as $key=>$val){                
                    $exp = explode('.', $key);
                    if(isset($exp[2]) && in_array($exp[2], ['view','create','edit'])){
                        $v[$exp[0].'.'.$exp[1].'.'.$transforms[$exp[2]]] = (bool) $val;                        
                    }
                    $v[$key] = (bool) $val;
                }                
                $role->permissions = json_encode($v);
                $role->save();
            }            
        }

        // set new permission to current user
        $user = \Sentinel::getUser();
        $role = $user->roles()->first();
        AdminHelper::setMenuSession($role);
        
        $request->session()->flash('message', __('Data berhasil disimpan'));
        return redirect()->route('cms.rolemanagement.create');
	}
	
}
