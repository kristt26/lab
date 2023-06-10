<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Komponen extends BaseController
{
    protected $komponen;
    protected $ta;

    public function __construct() {
        $this->komponen = new \App\Models\KomponenModel();
        $this->ta = new \App\Models\TaModel();
    }
    public function index()
    {
        return view('admin/komponen', ['title'=>'Komponen Penilaian']);
    }

    public function store()
    {
        return $this->respond($this->komponen->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->komponen->find($id));
    }

    public function post()
    {
        $ta = $this->ta->where('status', '1')->first(); 
        $data = $this->request->getJSON();
        $data->ta_id = $ta['id'];
        try {
            $this->komponen->insert($data);
            $data->id = $this->komponen->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->komponen->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id = null)
    {
        try {
            $this->komponen->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
