<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TaModel;

class Ta extends BaseController
{
    protected $ta;

    public function __construct() {
        $this->ta = new TaModel();
    }
    public function index()
    {
        return view('admin/ta', ['title'=>'Tahun Akademik']);
    }

    public function store()
    {
        return $this->respond($this->ta->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->ta->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            if($data->status =='1'){
                $this->ta->where('status', '1')->set('status','0')->update();
            }
            $this->ta->insert($data);
            $data->id = $this->ta->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            if($data->status =='1'){
                $this->ta->where('status', '1')->set('status','0')->update();
            }
            $this->ta->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id = null)
    {
        try {
            $this->ta->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
