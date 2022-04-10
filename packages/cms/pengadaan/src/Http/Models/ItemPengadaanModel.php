<?php

namespace Cms\Pengadaan\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPengadaanModel extends Model
{    
    
    protected $table = 'item_pengadaan';    
    protected $fillable = [
    	'pengadaan_id',
        'nama_barang',        
        'spesifikasi_barang',
        'uraian_barang',
        'qty',
        'keterangan',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $loginNames = ['email'];

    public function pengadaan(){
        return $this->hasOne('Cms\Pengadaan\Http\Models\PengadaanModel', 'pengadaan_id', 'id');
    }

}
