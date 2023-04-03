<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KelasModel;

class Kelas extends BaseController
{
    use ResponseTrait;
    protected $kelas;

    public function __construct()
    {
        $this->kelas = new KelasModel();
    }
    public function index()
    {
        return view('admin/kelas', ['title' => 'Kelas']);
    }

    public function store()
    {
        return $this->respond($this->kelas->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->kelas->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->kelas->insert($data);
            $data->id = $this->kelas->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->kelas->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->kelas->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
