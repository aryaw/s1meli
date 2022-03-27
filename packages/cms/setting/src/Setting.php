<?php 

namespace Cms\Setting;

use Illuminate\Support\Facades\Cache;
use Cms\Setting\Http\Models\SettingModel;

class Setting
{
    private $cacheName = 'settings';    

	public function setting($key, $default = null)
    {
        $value = $default;

        $settings = Cache::rememberForever($this->cacheName, function () {
            return SettingModel::pluck('value','key')->all();
        });

        if($settings){
            $value = isset($settings[$key]) ? $settings[$key] : $default;
        }

        return $value;        
    }

    public function forgetSetting(){
        Cache::forget($this->cacheName);
    }

}