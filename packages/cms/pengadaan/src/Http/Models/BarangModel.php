<?php

namespace Cms\Pengadaan\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{    
    
    
    protected $table = 'barang';    
    protected $fillable = [
    	'kode_barang',
        'nama',
        'kategory',
        'merk',
        'bahan',
        'spesifikasi',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function scopeNormalBarang($query){
        $query
            ->select('barang.*');
        return $query;
    }
}
