<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Jadwal extends BaseController
{
    protected $jurusan;
    protected $matakuliah;
    protected $ta;
    protected $kelas;
    protected $jadwal;
    protected $dosen;
    protected $conn;

    public function __construct()
    {
        $this->jurusan = new \App\Models\JurusanModel();
        $this->matakuliah = new \App\Models\MatkulModel();
        $this->ta = new \App\Models\TaModel();
        $this->kelas = new \App\Models\KelasModel();
        $this->jadwal = new \App\Models\JadwalModel();
        $this->dosen = new \App\Models\DosenModel();
        $this->conn = \Config\Database::connect();
    }
    public function index()
    {
        return view('admin/jadwal', ['title' => 'Jadwal']);
    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        $jadwal = $this->jadwal->select("jadwal.*, ta.tahun_akademik, kelas.kelas, matakuliah.nama_matakuliah, dosen.nama_dosen , matakuliah.jurusan_id, (SELECT COUNT(*) FROM rooms WHERE jadwal_id= jadwal.id) as jumlah_mahasiswa")
            ->join("ta", "ta.id = jadwal.ta_id", "LEFT")
            ->join('kelas', "kelas.id = jadwal.kelas_id", "left")
            ->join('matakuliah', "matakuliah.id = jadwal.matakuliah_id", "LEFT")
            ->join('dosen', "dosen.id = jadwal.dosen_id", "LEFT")
            ->where('ta.status', '1')
            ->findAll();
        $dup = [];
        foreach ($jadwal as $key => $value) {
            $item = [];
            foreach ($jadwal as $key => $value1) {
                if($value['hari']==$value1['hari'] && $value['jam_mulai']==$value1['jam_mulai'] && $value['jam_selesai']==$value1['jam_selesai'] && $value['ruang']==$value1['ruang']) $item[]=$value;
            }
            if(count($item)>1){
                foreach ($item as $key => $set) {
                    $dup[] = $set;
                }
            }
        }
        
        $matakuliah = $this->matakuliah->findAll();
        foreach ($jurusans as $key => $jurusan) {
            $jurusan->matakuliah = [];
            $jurusan->jadwal = [];
            foreach ($matakuliah as $key => $value) {
                if ($value['jurusan_id'] == $jurusan->id) $jurusan->matakuliah[] = $value;
            }
            foreach ($jadwal as $key => $value) {
                if ($value['jurusan_id'] == $jurusan->id) $jurusan->jadwal[] = $value;
            }
        }

        $data = [
            "jurusan" => $jurusans,
            "kelas" => $this->kelas->findAll(),
            "dosen" => $this->dosen->findAll(),
            "ta" => $this->ta->where('status', '1')->first(),
            "dup" => $dup
        ];
        return $this->respond($data);
    }

    public function read($id = null)
    {
        return $this->respond($this->jurusan->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->jadwal->insert($data);
            $data->id = $this->jurusan->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->jadwal->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->jadwal->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
