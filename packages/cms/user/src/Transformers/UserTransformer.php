<?php 
namespace Cms\User\Transformers;

use League\Fractal\TransformerAbstract;

use Cms\User\Http\Models\UserModel;

class UserTransformer extends TransformerAbstract
{
    public function transform(UserModel $user)
    {          
        $activation = 'INACTIVE';
        if($user->activation && $user->activation->completed){
            $activation = 'ACTIVE';
        }

    	return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'full_name' => $user->full_name,
            'username' => $user->username,
            'address' => $user->address,
            'gender' => $user->gender,
            'photo' => ($user->photo) ? url($user->photo) : '',
            'phone' => $user->phone,
            'phone2' => $user->phone2,
            'company_name' => $user->company_name,
            'status' => $activation,
            'last_login' => ($user->last_login) ? $user->last_login->format('d-m-Y H:i:s') : '',
            'created_at' => $user->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user->updated_at->format('d-m-Y H:i:s'),
        ];
    }

}