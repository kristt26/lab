<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MatkulModel;
use App\Models\ModulModel;
use CodeIgniter\API\ResponseTrait;

class Modul extends BaseController
{
    use ResponseTrait;
    protected $modul;
    protected $matakuliah;

    public function __construct()
    {
        $this->modul = new ModulModel();
        $this->matakuliah = new MatkulModel();
    }
    public function index()
    {
        return view('admin/modul', ['title' => 'Modul']);
    }

    public function store()
    {
        $matakuliahs = $this->matakuliah->asObject()->findAll();
        foreach ($matakuliahs as $key => $matakuliah) {
            $matakuliah->matakuliah = $this->matakuliah->where('matakuliah_id', $matakuliah->id)->findAll();
        }
        return $this->respond($matakuliahs);

        return $this->respond($this->modul->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->modul->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->modul->insert($data);
            $data->id = $this->modul->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable$th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->modul->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable$th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->modul->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable$th) {
            return $this->fail($th->getMessage());
        }
    }
}
