<?php 
namespace Cms\Pengadaan\Transformers;

use League\Fractal\TransformerAbstract;

use Cms\Pengadaan\Http\Models\BarangModel;

class BarangTransformer extends TransformerAbstract
{
    public function transform(BarangModel $barang)
    {          
        $status = 'Inactive';
        if($barang->status && $barang->status == 1){
            $status = 'Active';
        }
        
        return [
            'id' => $barang->id,
            'nama' => $barang->nama,
            'merk' => $barang->merk,
            'bahan' => $barang->bahan,
            'spesifikasi' => $barang->spesifikasi,
            'status' => $barang->status,
        ];
    }

}