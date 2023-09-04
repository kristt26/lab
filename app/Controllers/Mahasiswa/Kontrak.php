<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\KontrakModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;
use App\Models\TaModel;

class Kontrak extends BaseController
{
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
        $myTime = new Time('now');
        $tgl = $myTime->toDateString();
        $data['jadwal'] = $this->jadwal->select("jadwal.*, matakuliah.kode, matakuliah.nama_matakuliah, matakuliah.jurusan_id, 
            jurusan.jurusan, jurusan.initial, matakuliah.semester, kelas.kelas,
            (SELECT modul.modul FROM modul where matakuliah.id=modul.matakuliah_id and status='1') AS modul,
            (SELECT COUNT(rooms.id) FROM rooms where jadwal.id=rooms.jadwal_id) AS jumlah,
            (SELECT pertemuan.id FROM pertemuan where mengawas.id=pertemuan.mengawas_id AND DATE(pertemuan.tgl)='$tgl' AND pertemuan.status='1') AS pertemuan_id,
            (SELECT pertemuan.tgl FROM pertemuan where mengawas.id=pertemuan.mengawas_id AND DATE(pertemuan.tgl)='$tgl' AND pertemuan.status='1') AS tanggal_pertemuan")
            ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id', 'LEFT')
            ->join('kelas', 'kelas.id=jadwal.kelas_id', 'LEFT')
            ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id', 'LEFT')
            ->join('mengawas', 'mengawas.jadwal_id=jadwal.id', 'LEFT')
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
            if($data->kapasitas !== 0 && $this->kontrak->where('jadwal_id', $data->jadwal_id)->countAllResults()<$data->kapasitas){
                $cek = $this->kontrak
                ->join('jadwal', 'jadwal.id=rooms.jadwal_id', 'LEFT')
                ->where('matakuliah_id', $data->matakuliah_id)
                ->where('mahasiswa_id', $data->mahasiswa_id)
                ->countAllResults();
                if($cek==0){
                    $this->kontrak->insert($data);
                    $data->id = $this->kontrak->getInsertID();
                    return $this->respondCreated($data);
                }else throw new \Exception("Anda hanya bisa memilih 1 shift matakuliah", 1);
                
            }else throw new \Exception("Kelas telah penuh\nSilahkan pilih kelas lain", 1);
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
