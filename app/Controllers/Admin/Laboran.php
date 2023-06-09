<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Laboran extends BaseController
{
    protected $daftar;
    protected $laboran;
    protected $db;
    public function __construct() {
        $this->daftar = new \App\Models\DaftarLaboranModel();
        $this->laboran = new \App\Models\LaboranModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        return view('admin/laboran', ['title' => 'Laboran']);
    }
    public function store()
    {
        $data = [
            "laboran" => $this->laboran->select("mahasiswa.*")->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id')->findAll(),
            "daftar" => $this->daftar->select("mahasiswa.*, pendaftaran_laboran.id as pendaftaran_laboran_id, pendaftaran_laboran.alasan")->join('mahasiswa', 'mahasiswa.id=pendaftaran_laboran.mahasiswa_id')->where('pendaftaran_laboran.status', 'Mendaftar')->findAll()
        ];
        return $this->respond($data);
    }

    public function read($id = null)
    {
        //
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->db->transBegin();
            $this->laboran->insert(['mahasiswa_id'=>$data->id]);
            $this->db->table('userrole')->insert(['user_id' => $data->user_id, 'role_id' => '3']);
            $this->daftar->where('mahasiswa_id', $data->id)->update(null, ['status'=>'Terima']);
            if($this->db->transStatus())
            {
                $this->db->transCommit();
                return $this->respond(true);
            }else{
                $this->db->transRollback();
                return $this->fail('Gagal');
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        //
    }

    public function delete($id = null)
    {
        try {
            $this->daftar->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
