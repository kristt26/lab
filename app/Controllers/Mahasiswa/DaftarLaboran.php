<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\TaModel;
use App\Models\DaftarLaboranModel;
use App\Models\LaboranModel;

class DaftarLaboran extends BaseController
{
    protected $mahasiswa;
    protected $ta;
    protected $pendaftaranLaboran;
    protected $laboran;

    public function __construct()
    {
        $this->ta = new TaModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->pendaftaranLaboran = new DaftarLaboranModel();
        $this->laboran = new LaboranModel();
    }
    public function index()
    {
        return view('mahasiswa/daftar_laboran', ['title' => 'Daftar Laboran']);
    }

    public function store()
    {
        $mhs = $this->mahasiswa->where('user_id', session()->get('uid'))->first();
        $laboran = $this->laboran->where('mahasiswa_id', $mhs['id'])->first();
        $daftar = $this->pendaftaranLaboran->where('mahasiswa_id', $mhs['id'])->first();
        return $this->respond($laboran!=null || $daftar!=null ? true : false);
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $mhs = $this->mahasiswa->where('user_id', session()->get('uid'))->first();
        try {
            $data->mahasiswa_id = $mhs['id'];
            $data->status = 'Mendaftar';
            $this->pendaftaranLaboran->insert($data);
            $data->id = $this->pendaftaranLaboran->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
