<?php

namespace App\Controllers\Laboran;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KontrakModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;
use App\Models\TaModel;
use App\Models\MengawasModel;

class Mengawas extends BaseController
{
    use ResponseTrait;
    protected $kontrak;
    protected $jadwal;
    protected $mahasiswa;
    protected $ta;
    protected $mengawas;

    public function __construct()
    {
        $this->kontrak = new KontrakModel();
        $this->jadwal = new JadwalModel();
        $this->ta = new TaModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->mengawas = new MengawasModel();
    }
    
    public function index()
    {
        return view('laboran/mengawas', ['title' => 'Mengawas']);
    }

    public function store()
    {
        $ta = $this->ta->where('status', '1')->first();
        $data['jadwal'] = $this->jadwal->select('jadwal.*, matakuliah.kode, matakuliah.nama_matakuliah, matakuliah.jurusan_id, matakuliah.semester, kelas.kelas')
            ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id')
            ->join('kelas', 'kelas.id=jadwal.kelas_id')
            ->where('ta_id', $ta['id'])->findAll();
        $data['mengawas'] = $this->mengawas->select("mengawas.*")
            ->join('laboran', 'laboran.id=mengawas.laboran_id', 'LEFT')
            ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'LEFT')
            ->join('jadwal', 'jadwal.id=mengawas.jadwal_id')
            ->where('user_id', session()->get('uid'))
            ->where('ta_id', $ta['id'])
            ->findAll();
        $data['ta'] = $ta;
        return $this->respond($data);
    }

    public function read($id = null)
    {
        return $this->respond($this->kontrak->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $mhs = $this->mahasiswa->where('user_id', session()->get('uid'))->first();
        try {
            $data->mahasiswa_id = $mhs['id'];
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
