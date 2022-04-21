<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Apa
    |--------------------------------------------------------------------------
    |
    | Bla bla bla
    |
    */    
    'document_mime' => 'application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',

    'image_mime' => 'image/jpeg,image/png,image/jpg',

    'publish_status' => [
        ['value' => 'draft', 'name'=>'DRAFT'],
        ['value' => 'publish', 'name'=>'PUBLISH'],        
    ],    

    'gender' => [
        ['value' => 'male', 'name'=>'MALE'],
        ['value' => 'female', 'name'=>'FEMALE'],
    ],
    
    'yes_no' => [
        ['value' => 'yes', 'name'=>'YES'],
        ['value' => 'no', 'name'=>'NO'],
    ],           

];