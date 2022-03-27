<?php
/**
 * Local Helper not global
 * 
 */ 
namespace Cms\Pengadaan\Helpers; 

class AdminHelper {
    
    public static function setMenuSession($role) {    	
        $menus = config('app.menu');
        $permissions = ($role) ? $role->permissions : [];
        $myMenus = [];

        foreach($menus as $menu){
            if(isset($menu['subs']) && $menu['subs']){
                $ngsubs = [];
                foreach($menu['subs'] as $k=>$v){
                    if(isset($permissions[$v['permission']]) && $permissions[$v['permission']]){
                        $ngsubs[] = $v;
                    }
                }

                if($ngsubs){
                    $menu['subs'] = $ngsubs;
                    $myMenus[] = $menu;
                }
            }else{
                if(isset($permissions[$menu['permission']]) && $permissions[$menu['permission']]){
                    $myMenus[] = $menu;
                }
            }
        }

        session(['menus' => $myMenus]);        
    }
}