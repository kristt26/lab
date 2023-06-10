<?php

namespace App\Controllers\Laboran;

use App\Controllers\BaseController;
use App\Models\KontrakModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;
use App\Models\TaModel;
use App\Models\MengawasModel;
use App\Models\LaboranModel;
use App\Models\TugasModel;

class Pertemuan extends BaseController
{
    protected $kontrak;
    protected $jadwal;
    protected $mahasiswa;
    protected $ta;
    protected $mengawas;
    protected $laboran;

    public function __construct()
    {
        $this->kontrak = new KontrakModel();
        $this->jadwal = new JadwalModel();
        $this->ta = new TaModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->mengawas = new MengawasModel();
        $this->laboran = new LaboranModel();
    }
    
    public function index($id = null)
    {
        return view('laboran/absen_rooms', ['title' => 'Jadwal Mengawas']);
    }

    public function store($id = null)
    {
        $data = $this->kontrak->select("rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm")
        ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id', 'LEFT')
        ->where('jadwal_id', $id)
        ->findAll();
        return $this->respond($data);
    }

    public function read($id = null)
    {
        return $this->respond($this->kontrak->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $laboran = $this->laboran->select("laboran.*")->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id')->where('user_id', session()->get('uid'))->first();
            $data->laboran_id = $laboran['id'];
            $this->mengawas->insert($data);
            $data->id = $this->mengawas->getInsertID();
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
            $this->mengawas->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
