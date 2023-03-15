<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\JurusanModel;

class Matakuliah extends BaseController
{
    use ResponseTrait;
    protected $matakuliah;

    public function __construct() {
        $this->matakuliah = new JurusanModel();
    }
    public function index()
    {
        return view('admin/matakuliah');
    }

    public function add()
    {
        return view('admin/jurusan/add', ['title'=>'Jurusan']);
    }

    public function store()
    {
        return $this->respond($this->matakuliah->findAll());
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
            $this->matakuliah->update($data);
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
