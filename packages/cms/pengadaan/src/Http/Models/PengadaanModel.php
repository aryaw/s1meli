<?php

namespace Cms\Pengadaan\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanModel extends Model
{    
    
    
    protected $table = 'pengadaan';    
    protected $fillable = [
    	'user_id',
        'status',        
        'permissions',
        'pengajuan',
        'approve_wakasek',
        'approve_kepsek',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function item_pengadaan(){
        return $this->hasMany('Cms\Pengadaan\Http\Models\ItemPengadaanModel', 'pengadaan_id', 'id');
    }

    public function user(){
        return $this->hasOne('Cms\User\Http\Models\UserModel', 'id', 'user_id');
    }

    public function scopeNormalPengadaan($query){
        $query
            ->select('pengadaan.*')
            ->join('users', 'users.id', 'pengadaan.user_id');
        return $query;
    }

}
