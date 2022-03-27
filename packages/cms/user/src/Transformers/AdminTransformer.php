<?php 
namespace Cms\User\Transformers;

use League\Fractal\TransformerAbstract;

use Cms\User\Http\Models\UserModel;


class AdminTransformer extends TransformerAbstract
{
    public function transform(UserModel $user)
    {  
    	return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'last_login' => ($user->last_login) ? $user->last_login->format('d-m-Y H:i:s') : '-',
            'created_at' => $user->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $user->updated_at->format('d-m-Y H:i:s'),
        ];
    }

}