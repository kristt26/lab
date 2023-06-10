<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Modul extends BaseController
{
    protected $modul;
    protected $matakuliah;
    protected $jurusan;

    public function __construct()
    {
        $this->modul = new \App\Models\ModulModel();
        $this->matakuliah = new \App\Models\MatkulModel();
        $this->jurusan = new \App\Models\JurusanModel();
    }
    public function index()
    {
        return view('admin/modul', ['title' => 'Modul']);
    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        // foreach ($jurusans as $key => $jurusan) {
        //     $jurusan->matakuliah = 
        // }
        // $matakuliahs = $this->matakuliah->asObject()->findAll();
        // foreach ($matakuliahs as $key => $matakuliah) {
        //     $matakuliah->modul = $this->modul->where('matakuliah_id', $matakuliah->id)->findAll();
        // }
        return $this->respond($jurusans);

        // return $this->respond($this->modul->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->modul->find($id));
    }

    public function by_matakuliah($id = null)
    {
        return $this->respond($this->modul->where('matakuliah_id', $id)->findAll());
    }


    public function post()
    {
        $data = $this->request->getJSON();
        $decode = new \App\Libraries\Decode();
        $data->modul = $decode->decodebase64($data->berkas->base64);
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
        helper('filesystem');
        $data = $this->request->getJSON();
        $decode = new \App\Libraries\Decode();
        try {
            if(isset($data->berkas)){
                if(unlink('assets/berkas/'.$data->modul)){
                    $data->modul = $decode->decodebase64($data->berkas->base64);
                }
            }
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
