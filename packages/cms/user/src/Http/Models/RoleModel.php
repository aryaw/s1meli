<?php

namespace Cms\User\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{    
    protected $table = 'roles';
    protected $fillable = [
    	'name',
    	'slug',
    	'permissions'
    ];

    public function scopeFilterRole($query){
        $query->where('slug', '!=', 'user');
        
        return $query;
    }

    public function scopeFilterRoleUser($query){
        $query->where('slug', '!=', 'administrator');
        
        return $query;
    }
    
}
