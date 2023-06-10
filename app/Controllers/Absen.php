<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Absen extends BaseController
{
    public function insert($id=null, $pertemuan_id = null)
    {
        $absen = new \App\Models\AbsenModel();
        $myTime = new Time('now');
        $tgl = $myTime->toDateString();
        try {
            $cek = $absen->where('rooms_id', $id)->where('DATE(tgl)', $tgl)->where('pertemuan_id', $pertemuan_id)->countAllResults();
            if($cek == 0){
                $absen->insert(['rooms_id'=>$id, 'status'=>'H', 'tgl'=>$myTime, 'pertemuan_id'=>$pertemuan_id]);
                return $this->respond(true);
            }else{
                return $this->fail("Anda sudah absen hari ini");
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
