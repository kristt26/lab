<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KontrakModel;

class Kontrak extends BaseController
{
    use ResponseTrait;
    protected $kontrak;

    public function __construct()
    {
        $this->kontrak = new KontrakModel();
    }
    public function index()
    {
        return view('mahasiswa/kontrak', ['title' => 'Kontrak']);
    }

    public function store()
    {

        return $this->respond($this->kontrak->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->kontrak->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->kontrak->insert($data);
            $data->id = $this->kontrak->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->kontrak->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->kontrak->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
