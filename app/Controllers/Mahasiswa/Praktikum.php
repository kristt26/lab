<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\KontrakModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;
use App\Models\PertemuanModel;
use App\Models\TaModel;
use App\Models\TugasModel;
use App\Models\UasModel;

class Praktikum extends BaseController
{
    protected $kontrak;
    protected $jadwal;
    protected $mahasiswa;
    protected $ta;
    protected $pertemuan;
    protected $tugas;
    protected $uas;

    public function __construct()
    {
        $this->kontrak = new KontrakModel();
        $this->jadwal = new JadwalModel();
        $this->ta = new TaModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->pertemuan = new PertemuanModel();
    }
    public function index()
    {
        return view('mahasiswa/praktikum', ['title' => 'Praktikum']);
    }

    public function store()
    {
        $ta = $this->ta->where('status', '1')->first();
        $mhs = $this->mahasiswa->where('user_id', session()->get('uid'))->first();
        $myTime = new Time('now');
        $tgl = $myTime->toDateString();
        $data['jadwal'] = $this->jadwal->select("jadwal.*, matakuliah.kode, matakuliah.nama_matakuliah, matakuliah.jurusan_id, 
            jurusan.jurusan, jurusan.initial, matakuliah.semester, kelas.kelas,
            mahasiswa.nama_mahasiswa as laboran,
            (SELECT modul.modul FROM modul where matakuliah.id=modul.matakuliah_id and status='1') AS modul,
            (SELECT COUNT(pertemuan.id) FROM pertemuan where mengawas.id=pertemuan.mengawas_id AND DATE(pertemuan.tgl)='$tgl' AND pertemuan.status='1') AS pertemuan,
            (SELECT pertemuan.id FROM pertemuan where mengawas.id=pertemuan.mengawas_id AND DATE(pertemuan.tgl)='$tgl' AND pertemuan.status='1') AS pertemuan_id,
            (SELECT pertemuan.tgl FROM pertemuan where mengawas.id=pertemuan.mengawas_id AND DATE(pertemuan.tgl)='$tgl' AND pertemuan.status='1') AS tanggal_pertemuan")
            ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id', 'LEFT')
            ->join('kelas', 'kelas.id=jadwal.kelas_id', 'LEFT')
            ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id', 'LEFT')
            ->join('mengawas', 'mengawas.jadwal_id=jadwal.id', 'LEFT')
            ->join('laboran', 'laboran.id=mengawas.laboran_id', 'LEFT')
            ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'LEFT')
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

    public function absenbyid($id = null, $rooms_id = null)
    {
        $pertemuan = $this->pertemuan->join('mengawas', 'mengawas.id=pertemuan.mengawas_id', 'LEFT')
        ->where("mengawas.jadwal_id", $id)->countAllResults();
        $item = $this->pertemuan->select("pertemuan.*, absen.tgl, absen.by, absen.status")
        ->join('absen', 'absen.pertemuan_id=pertemuan.id')
        ->where('absen.rooms_id', $rooms_id)->findAll();
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            if($i < $pertemuan){
                $cek = false;
                foreach ($item as $key => $value) {
                    if((string)($i+1) == $value['pertemuan']){
                        $cek = true;
                        break;
                    }
                }
                if($cek) $data[] = $value;
                else{
                    $set = ['pertemuan' => $i+1, 'tgl' => null, 'status' => "A", 'by' => 'System'];
                    $data[] = $set;
                }
            }else{
                $set = ['pertemuan' => $i+1, 'tgl' => null,'status' => null];
                $data[] = $set;
            }
        }
        return $this->respond($data);
    }

    public function nilaibyid($id = null, $rooms_id= null)
    {
        $this->tugas = new TugasModel();
        $this->uas = new UasModel();
        $item['tugas'] = $this->tugas->select("tugas.*, detail_tugas.nilai")
        ->join('detail_tugas', 'tugas.id=detail_tugas.tugas_id')
        ->where('tugas.jadwal_id', $id)
        ->where('detail_tugas.rooms_id', $rooms_id)->findAll();
        $item['uas'] = $this->uas->where("rooms_id", $rooms_id)->first();
        return $this->respond($item);
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
