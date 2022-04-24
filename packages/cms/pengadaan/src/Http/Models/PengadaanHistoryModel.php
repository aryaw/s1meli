<?php

namespace Cms\Pengadaan\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanHistoryModel extends Model
{    
    
    
    protected $table = 'pengadaan';    
    protected $fillable = [
    	'pengadaan_id',
        'pengajuan',
        'tgl_approve_wakasek',
        'tgl_approve_kepsek',
        'approve_wakasek',
        'approve_kepsek',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function pengadaan(){
        return $this->hasOne('Cms\Pengadaan\Http\Models\PengadaanModel', 'id', 'pengadaan_id');
    }
}
