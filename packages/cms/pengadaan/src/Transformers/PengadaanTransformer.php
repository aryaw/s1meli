<?php 
namespace Cms\Pengadaan\Transformers;

use League\Fractal\TransformerAbstract;

use Cms\Pengadaan\Http\Models\PengadaanModel;

class PengadaanTransformer extends TransformerAbstract
{
    public function transform(PengadaanModel $pengadaan)
    {          
        $full_name = '';
        if($pengadaan->user && $pengadaan->user->full_name){
            $full_name = $pengadaan->user->full_name;
        }

        $status = 'Inactive';
        if($pengadaan->status && $pengadaan->status == 1){
            $status = 'Active';
        }

        $approve_wakasek = 'Pending';
        if($pengadaan->related_history->approve_wakasek && $pengadaan->related_history->approve_wakasek == 1){
            $approve_wakasek = 'Confirm';
        }

        $approve_kepsek = 'Pending';
        if($pengadaan->related_history->approve_kepsek && $pengadaan->related_history->approve_kepsek == 1){
            $approve_kepsek = 'Confirm';
        }
        
        return [
            'id' => $pengadaan->id,
            'user_id' => $pengadaan->user_id,
            'nota' => $pengadaan->nota,
            'status' => $status,
            'pengajuan' => $pengadaan->pengajuan,
            'full_name' => $full_name,
            'approve_wakasek' => $approve_wakasek,
            'approve_kepsek' => $approve_kepsek,
        ];
    }

}