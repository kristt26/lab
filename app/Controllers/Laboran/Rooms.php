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
        $data = $this->pertemuan->select("pertemuan.*, mengawas.jadwal_id")
            ->join('mengawas', 'mengawas.id=pertemuan.mengawas_id', 'LEFT')
            ->where('jadwal_id', $id)
            ->findAll();
        return $this->respond($data);
    }

    public function by_pertemuan($pertemuan_id = null, $jadwal_id=null)
    {
        try {
            $conn = \Config\Database::connect();
            $data = $conn->query("SELECT
                `mahasiswa`.`nama_mahasiswa`,
                `mahasiswa`.`npm`,
                '$pertemuan_id' as pertemuan_id,
                rooms.id as id_rooms,
                `rooms`.*, (SELECT absen.status from absen where pertemuan_id='$pertemuan_id' and rooms_id=id_rooms) as status,(SELECT absen.by from absen where pertemuan_id='$pertemuan_id' and rooms_id=id_rooms) as 'by',(SELECT absen.id from absen where pertemuan_id='$pertemuan_id' and rooms_id=id_rooms) as absen_id
            FROM
                `rooms`
                LEFT JOIN `mahasiswa` ON `rooms`.`mahasiswa_id` = `mahasiswa`.`id`
            WHERE jadwal_id = '$jadwal_id'")->getResult();
            // $data = $this->rooms
            //     ->select("rooms.*, rooms.id as id_rooms, mahasiswa.nama_mahasiswa, mahasiswa.npm, pertemuan.id as pertemuan_id, matakuliah.nama_matakuliah,
            //     (SELECT absen.status from absen where pertemuan_id='$pertemuan_id' and rooms_id=id_rooms) as status,
            //     (SELECT absen.by from absen where pertemuan_id='$pertemuan_id' and rooms_id=id_rooms) as 'by',
            //     (SELECT absen.id from absen where pertemuan_id='$pertemuan_id' and rooms_id=id")
            //     ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id', 'LEFT')
            //     ->where('jadwal_id', $jadwal_id)
            //     ->findAll();
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
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
