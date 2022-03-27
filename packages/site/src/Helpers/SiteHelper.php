<?php

function thousandFormat($number){
    return number_format($number, 0, ',', '.');
}

function getUser(){
    $user = Sentinel::getUser();
    if($user){
        $role = $user->roles()->first();
        if($role && $role->slug == 'user'){
            return $user;
        }
    }
    return false;
}

function setActiveClass($path){
    return (Request::is($path.'*')) ? 'active' : '';
}

// https://stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
function slugify($text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');
    
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    
    // lowercase
    $text = strtolower($text);
    
    if (empty($text)) {
        return 'n-a';
    }
    
    return $text;
}

/* function encodeId($id){
    $hashids = new Hashids\Hashids('', 10);
    return $hashids->encode($id);    
}

function decodeId($hash){
    $hashids = new Hashids\Hashids('', 10);
    $ids = $hashids->decode($hash);    
    return isset($ids[0]) ? $ids[0] : 0;
} */