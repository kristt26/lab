<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Absen extends BaseController
{
    public function insert($id=null, $pertemuan_id = null)
    {
        $conn = \Config\Database::connect();
        $absen = new \App\Models\AbsenModel();
        $pertemuan = new \App\Models\PertemuanModel();
        $kom = new \App\Models\DetailKomponenModel();
        $rooms = new \App\Models\KontrakModel();
        $nilai = new \App\Models\NilaiModel();
        $dtRooms = $rooms->where('id', $id)->first();
        $jmPertamuan = $pertemuan->join("mengawas", "mengawas.id=pertemuan.mengawas_id")->where('jadwal_id', $dtRooms['jadwal_id'])->countAllResults();
        $dtKom = $kom->asObject()->select("detail_komponen.*")->where('komponen_id', 2)->where('jadwal_id', $dtRooms['jadwal_id'])->first();
        $myTime = new Time('now');
        $tgl = $myTime->toDateString();
        try {
            $cek = $absen->where('rooms_id', $id)->where('DATE(tgl)', $tgl)->where('pertemuan_id', $pertemuan_id)->countAllResults();
            if($cek == 0){
                $conn->transException(true)->transStart();
                $absen->insert(['rooms_id'=>$id, 'status'=>'H', 'tgl'=>$myTime, 'pertemuan_id'=>$pertemuan_id]);
                $dtAbsen = $absen->where('rooms_id', $id)->findAll();
                $h = 0;
                foreach ($dtAbsen as $key => $value) {
                    if($value['status']=="H") $h+=1;
                    else if($value['status']=="S") $h+=0.5;
                    else if($value['status']=="I") $h+=0.25;
                }
                $nilai->where("detail_komponen_id='$dtKom->id' AND rooms_id = '$id'")->update(null, ['nilai'=>($h/$jmPertamuan*100)*($dtKom->bobot/100)]);
                $conn->transComplete();
                return $this->respond(true);
                
            }else{
                return $this->fail("Anda sudah absen hari ini");
            }
        } catch (\Throwable $th) {
            $conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }
}
