<?php

namespace App\Controllers\Laboran;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Rooms extends BaseController
{
    use ResponseTrait;
    protected $pertemuan;
    protected $rooms;
    protected $absen;
    public function __construct()
    {
        $this->pertemuan = new \App\Models\PertemuanModel();
        $this->rooms = new \App\Models\KontrakModel();
        $this->absen= new \App\Models\AbsenModel();
    }

    public function index($id = null)
    {
        return view('laboran/absen_rooms', ['title' => 'Jadwal Mengawas']);
    }

    public function store($id = null)
    {
        $data = $this->pertemuan->select("pertemuan.*")
            ->join('mengawas', 'mengawas.id=pertemuan.mengawas_id', 'LEFT')
            ->where('jadwal_id', $id)
            ->findAll();
        return $this->respond($data);
    }

    public function by_pertemuan($id = null)
    {
        $data = $this->rooms
            ->select("rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm, absen.status, absen.by, pertemuan.id as pertemuan_id, absen.id as absen_id, matakuliah.nama_matakuliah")
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id', 'LEFT')
            ->join('jadwal', 'jadwal.id=rooms.jadwal_id', 'LEFT')
            ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id', 'LEFT')
            ->join('mengawas', 'jadwal.id=mengawas.jadwal_id', 'LEFT')
            ->join('pertemuan', 'pertemuan.mengawas_id=mengawas.id', 'LEFT')
            ->join('absen', 'absen.rooms_id=rooms.id', 'LEFT')
            ->where('pertemuan.id', $id)
            ->findAll();
        return $this->respond($data);
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            if(is_null($data->absen_id)){
                $item = [
                    "rooms_id" =>$data->id,
                    "status"=>$data->status,
                    "by" => "lecture",
                    "pertemuan_id" => $data->pertemuan_id
                ];
                $this->absen->insert($item);
                $data->absen_id = $this->absen->getInsertID();
                return $this->respondCreated($data);
            }else{
                $this->absen->update($data->absen_id, ['status'=>$data->status, 'by'=>'lecture']);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        return $this->respond($data);
    }
}
