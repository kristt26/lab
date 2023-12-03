<?php

namespace App\Controllers\Laboran;

use App\Controllers\BaseController;
use App\Models\KontrakModel;
use App\Models\JadwalModel;
use App\Models\MahasiswaModel;
use App\Models\TaModel;
use App\Models\MengawasModel;
use App\Models\LaboranModel;
use App\Models\PertemuanModel;
use CodeIgniter\I18n\Time;

class Mengawas extends BaseController
{
    protected $kontrak;
    protected $jadwal;
    protected $mahasiswa;
    protected $ta;
    protected $mengawas;
    protected $laboran;
    protected $jlm;

    public function __construct()
    {
        $this->kontrak = new KontrakModel();
        $this->jadwal = new JadwalModel();
        $this->ta = new TaModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->mengawas = new MengawasModel();
        $this->laboran = new LaboranModel();
        $this->jlm = new PertemuanModel();
    }

    public function index()
    {
        return view('laboran/mengawas', ['title' => 'Mengawas']);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        try {
            $ta = $this->ta->where('status', '1')->first();
            $data['jadwal'] = $this->jadwal->asObject()->select("mengawas.id as mengawas_id, jurusan.jurusan, jurusan.initial, jadwal.*, matakuliah.kode, matakuliah.nama_matakuliah, matakuliah.jurusan_id, matakuliah.semester, kelas.kelas, 
                (SELECT COUNT(*) FROM rooms where rooms.jadwal_id=jadwal.id ) AS jmlmahasiswa,
                (SELECT modul.modul FROM modul where matakuliah.id=modul.matakuliah_id and status='1') AS modul,
                (SELECT COUNT(id) FROM pertemuan where mengawas.id=pertemuan.mengawas_id) AS jumlahPertemuan,
                mahasiswa.nama_mahasiswa")
                ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id')
                ->join('kelas', 'kelas.id=jadwal.kelas_id')
                ->join('mengawas', 'jadwal.id=mengawas.jadwal_id', 'LEFT')
                ->join('laboran', 'laboran.id=mengawas.laboran_id', 'LEFT')
                ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'LEFT')
                ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id', 'LEFT')
                ->where('ta_id', $ta['id'])->findAll();
            if (session()->get('role') == 'Laboran') {
                $data['mengawas'] = $this->mengawas->select("mengawas.*")
                    ->join('laboran', 'laboran.id=mengawas.laboran_id', 'LEFT')
                    ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'LEFT')
                    ->join('jadwal', 'jadwal.id=mengawas.jadwal_id', 'LEFT')
                    ->where('user_id', session()->get('uid'))
                    ->where('ta_id', $ta['id'])
                    ->findAll();
            } else {
                $data['mengawas'] = $this->mengawas->select("mengawas.*")
                    ->join('jadwal', 'jadwal.id=mengawas.jadwal_id', 'LEFT')
                    ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id')
                    ->join('dosen', 'dosen.id=jadwal.dosen_id')
                    ->where('user_id', session()->get('uid'))
                    ->where('ta_id', $ta['id'])
                    ->findAll();
            }
            $data['ta'] = $ta;
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function pertemuan()
    {
        $data = $this->request->getJSON();
        $myTime = new Time('now');
        $tgl = $myTime->toDateString();
        try {
            $data->jumlahPertemuan = $this->jlm->where('mengawas_id', $data->mengawas_id)->countAllResults() + 1;
            $cek = $this->jlm->where('DATE(tgl)', $tgl)->where('mengawas_id', $data->mengawas_id)->countAllResults();
            if ($cek == 0) {
                $this->jlm->where('status', '1')->where('mengawas_id', $data->mengawas_id)->update(null, ['status' => '0']);
                $this->jlm->insert(['mengawas_id' => $data->mengawas_id, 'status' => '1', 'pertemuan' => $data->jumlahPertemuan, 'tgl' => $data->tgl]);
                return $this->respondCreated($data);
            } else {
                if ($data->again) {
                    $this->jlm->where('status', '1')->where('mengawas_id', $data->mengawas_id)->update(null, ['status' => '0']);
                    $this->jlm->insert(['mengawas_id' => $data->mengawas_id, 'status' => '1', 'pertemuan' => $data->jumlahPertemuan, 'tgl' => $data->tgl]);
                    return $this->respondCreated($data);
                } else {
                    return $this->fail("Anda sudah Absen");
                }
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function read($id = null)
    {
        return $this->respond($this->kontrak->find($id));
    }

    public function read_mahasiswa($id = null)
    {
        return $this->respond($this->kontrak
            ->select('mahasiswa.*, kelas.kelas')
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id', 'left')
            ->join('kelas', 'kelas.id=mahasiswa.kelas_id', 'left')
            ->where('jadwal_id', $id)
            ->findAll());
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
