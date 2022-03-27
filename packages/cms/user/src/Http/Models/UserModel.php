<?php

namespace Cms\User\Http\Models;

use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

class UserModel extends CartalystUser
{    
    
    use Notifiable;

    protected $table = 'users';    
    protected $fillable = [
    	'email',
        'password',        
        'permissions',
        'last_login',
        'first_name',
        'last_name',

        'full_name',
        'address',
        'phone',
        'dob',
        'gender',
        'photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login'
    ];

    protected $loginNames = ['email'];

    public function role(){
        return $this->hasOne('Cms\User\Http\Models\RoleUserModel', 'user_id', 'id');
    }

    public function activation(){
        return $this->hasOne('Cartalyst\Sentinel\Activations\EloquentActivation', 'user_id');
    }

    public function scopeNormalUser($query){
        $query
            ->select('users.*')
            ->join('role_users', 'role_users.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_users.role_id')
            ->where('roles.slug', 'user');
        return $query;
    }

    public function scopeAdminUser($query){
        $query
            ->select('users.*')
            ->join('role_users', 'role_users.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_users.role_id')
            ->where('roles.slug', '=', 'administrator');
        return $query;
    }

    public function delete()
	{        
        $result = ResultModel::where('user_id', $this->id)->first();
        if($result){
            $suggestion = SuggestionModel::find($result->suggestion_id);
            if($suggestion){
                $suggestion->status = 'available';
                $suggestion->hold_time = NULL;
                $suggestion->used_time = NULL;
                $suggestion->save();
            }
        }
        
	    parent::delete();
	}

}
