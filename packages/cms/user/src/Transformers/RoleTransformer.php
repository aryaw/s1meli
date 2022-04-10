<?php 
namespace Cms\User\Transformers;

use League\Fractal\TransformerAbstract;

use Cms\User\Http\Models\RoleModel;


class RoleTransformer extends TransformerAbstract
{
    public function transform(RoleModel $role)
    {  
    	return [
            'id' => $role->id,
            'slug' => $role->slug,
            'name' => $role->name,
            'created_at' => $role->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $role->updated_at->format('d-m-Y H:i:s'),
        ];
    }

}