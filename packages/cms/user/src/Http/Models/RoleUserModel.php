<?php

namespace Cms\User\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUserModel extends Model
{    
    protected $table = 'role_users';
    protected $primaryKey = 'user_id';
    protected $fillable = [
    	'role_id',    	
    ];    
    
}
