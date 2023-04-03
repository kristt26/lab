<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MahasiswaModel;
use App\Models\JurusanModel;

class Mahasiswa extends BaseController
{
    use ResponseTrait;
    protected $mahasiswa;
    protected $jurusan;

    public function __construct()
    {
        $this->mahasiswa = new MahasiswaModel();
        $this->jurusan = new JurusanModel();
    }
    public function index()
    {
        return view('admin/mahasiswa', ['title' => 'Mahasiswa']);
    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        foreach ($jurusans as $key => $jurusan) {
            $jurusan->mahasiswa = $this->mahasiswa->where('jurusan_id', $jurusan->id)->findAll();
        }
        $data = [
            'jurusan'=>$jurusans,
            'jurusan'=>$jurusans
        ];
        return $this->respond($jurusans);
    }

    public function read($id = null)
    {
        return $this->respond($this->mahasiswa->find($id));
    }

        public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->mahasiswa->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id = null)
    {
        try {
            $this->mahasiswa->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
