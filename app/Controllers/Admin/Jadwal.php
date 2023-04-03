<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Jadwal extends BaseController
{
    use ResponseTrait;
    protected $jurusan;
    protected $matakuliah;
    protected $ta;
    protected $kelas;

    public function __construct() {
        $this->jurusan = new \App\Models\JurusanModel();
        $this->matakuliah = new \App\Models\MatkulModel();
        $this->ta = new \App\Models\TaModel();
        $this->kelas = new \App\Models\KelasModel();
    }
    public function index()
    {
        return view('admin/jadwal', ['title'=>'Jadwal']);
    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        foreach ($jurusans as $key => $jurusan) {
            $jurusan->matakuliah = $this->matakuliah->where('jurusan_id', $jurusan->id)->findAll();
        }
        $data = [
            "jurusan" => $jurusans,
            "kelas" => $this->kelas->findAll(),
            "ta" => $this->ta->where('status', '1')->first()
        ];
        return $this->respond($this->jurusan->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->jurusan->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->jurusan->insert($data);
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
            $this->jurusan->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id = null)
    {
        try {
            $this->jurusan->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
