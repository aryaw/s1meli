<?php

namespace Cms\Pengadaan\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanModel extends Model
{    
    
    
    protected $table = 'pengadaan';    
    protected $fillable = [
    	'user_id',
    	'actor',
        'nomor_laporan',
        'status',        
        'permissions',
        'pengajuan',
        'tgl_penerimaan',
        'nota',
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

    public function history(){
        return $this->hasMany('Cms\Pengadaan\Http\Models\PengadaanHistoryModel', 'pengadaan_id', 'id');
    }

    public function related_history(){
        return $this->hasOne('Cms\Pengadaan\Http\Models\PengadaanHistoryModel', 'pengadaan_id', 'id');
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

    public function scopeNormalPengadaanActive($query){
        $query
            ->select('pengadaan.*')
            ->where('status', '=', '1')
            ->join('users', 'users.id', 'pengadaan.user_id');
        return $query;
    }

    public function scopeNormalPengadaanPending($query){
        $query
            ->select('pengadaan.*')
            ->where('status', '=', '0')
            ->join('users', 'users.id', 'pengadaan.user_id');
        return $query;
    }

    public function scopeNormalPengadaanPendingWaka($query){
        $query
            ->select('pengadaan.*')
            ->where('pengadaan_history.approve_wakasek', '=', '0')
            ->join('users', 'users.id', 'pengadaan.user_id')
            ->join('pengadaan_history', 'pengadaan_history.pengadaan_id', 'pengadaan.id');
        return $query;
    }

    public function scopeNormalPengadaanPendingKepsek($query){
        $query
        ->select('pengadaan.*')
        ->where('pengadaan_history.approve_kepsek', '=', '0')
        ->join('users', 'users.id', 'pengadaan.user_id')
        ->join('pengadaan_history', 'pengadaan_history.pengadaan_id', 'pengadaan.id');
        return $query;
    }
}
