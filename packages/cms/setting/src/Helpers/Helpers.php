<?php 

if (!function_exists('setting')) {
    function setting($key, $default = null) {
        return Cms\Setting\Facades\SettingFacade::setting($key, $default);
    }
}
