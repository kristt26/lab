<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KontrakModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;
use App\Models\TaModel;

class Kontrak extends BaseController
{
    use ResponseTrait;
    protected $kontrak;
    protected $jadwal;
    protected $mahasiswa;
    protected $ta;

    public function __construct()
    {
        $this->kontrak = new KontrakModel();
        $this->jadwal = new JadwalModel();
        $this->ta = new TaModel();
        $this->mahasiswa = new MahasiswaModel();
    }
    public function index()
    {
        return view('mahasiswa/kontrak', ['title' => 'Kontrak']);
    }

    public function store()
    {
        $ta = $this->ta->where('status', '1')->first();
        $mhs = $this->mahasiswa->where('user_id', session()->get('uid'))->first();
        $data['jadwal'] = $this->jadwal->select('jadwal.*, matakuliah.kode, matakuliah.nama_matakuliah, matakuliah.jurusan_id, jurusan.jurusan, jurusan.initial, matakuliah.semester, kelas.kelas')
            ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id')
            ->join('kelas', 'kelas.id=jadwal.kelas_id')
            ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id')
            ->where('matakuliah.jurusan_id', $mhs['jurusan_id'])
            ->where('ta_id', $ta['id'])->findAll();
        $data['rooms'] = $this->kontrak->select("rooms.*")
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id', 'LEFT')
            ->join('jadwal', 'jadwal.id=rooms.jadwal_id')
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
