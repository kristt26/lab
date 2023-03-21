<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MatkulModel;
use App\Models\JurusanModel;

class Matakuliah extends BaseController
{
    use ResponseTrait;
    protected $matakuliah;
    protected $jurusan;

    public function __construct()
    {
        $this->matakuliah = new MatkulModel();
        $this->jurusan = new JurusanModel();
    }
    public function index()
    {
        return view('admin/matakuliah', ['title' => 'Matakuliah']);

    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        foreach ($jurusans as $key => $jurusan) {
            $jurusan->matakuliah = $this->matakuliah->where('jurusan_id', $jurusan->id)->findAll();
        }
        return $this->respond($jurusans);
    }

    public function read($id = null)
    {
        return $this->respond($this->matakuliah->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->matakuliah->insert($data);
            $data->id = $this->matakuliah->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->matakuliah->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id = null)
    {
        try {
            $this->matakuliah->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
