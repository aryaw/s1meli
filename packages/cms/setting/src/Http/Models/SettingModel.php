<?php

namespace Cms\Setting\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class SettingModel extends Model
{
    
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'group',
        'type',
        'order',
        'key',
        'name',
        'value',
        'is_deletable',
    ];

    public function delete()
    {
        if($this->type == 'image'){
            $path = str_replace('storage', 'public', $this->value);
            Storage::delete($path);
        }        

        parent::delete();
    }
    
}
