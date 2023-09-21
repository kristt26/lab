<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\KontrakModel;
use App\Models\LaboranModel;
use App\Models\MahasiswaModel;
use App\Models\TaModel;

class Home extends BaseController
{
    protected $ta;
    protected $jadwal;
    protected $rooms;
    protected $mhs;
    protected $laboran;
    public function index()
    {
        helper("find");
        $this->jadwal = new JadwalModel();
        $this->ta = new TaModel();
        $this->mhs = new MahasiswaModel();
        $this->rooms = new KontrakModel();
        $this->laboran = new LaboranModel();
        $ta = $this->ta->where('status', '1')->first();
        if (is_null(session()->get('is_login'))) return redirect()->to(base_url('auth'));
        if (session()->get('role') == 'Mahasiswa' && session()->get('change') == '0') return redirect()->to(base_url('profile'));
        if(session()->get('role')=='Admin'){
            $data = $this->jadwal
                ->select("jadwal.*, matakuliah.nama_matakuliah, matakuliah.semester, 
                mahasiswa.nama_mahasiswa, kelas.kelas, dosen.nama_dosen,
                (SELECT COUNT(rooms.id) FROM rooms where jadwal.id=rooms.jadwal_id) AS jumlah,
                right(jurusan.jurusan,4) as jurusan")
                ->join('dosen', 'dosen.id=jadwal.dosen_id', 'left')
                ->join('kelas', 'kelas.id=jadwal.kelas_id', 'left')
                ->join('mengawas', 'jadwal.id=mengawas.jadwal_id', 'left')
                ->join('laboran', 'laboran.id=mengawas.laboran_id', 'left')
                ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'left')
                ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id', 'left')
                ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id', 'left')
                ->where('ta_id', $ta['id'])
                ->where('hari', hari_ini())
                ->orderBy('jam_mulai')->findAll();
        } else if(session()->get('role')=='Mahasiswa'){
            $mhs = $this->mhs->where('user_id', session()->get('uid'))->first();
            $data = $this->rooms
                ->select("jadwal.*, matakuliah.nama_matakuliah, matakuliah.semester, 
                mahasiswa.nama_mahasiswa, kelas.kelas, dosen.nama_dosen,
                (SELECT COUNT(rooms.id) FROM rooms where jadwal.id=rooms.jadwal_id) AS jumlah,
                right(jurusan.jurusan,4) as jurusan")
                ->join('jadwal', 'jadwal.id=rooms.jadwal_id', 'left')
                ->join('dosen', 'dosen.id=jadwal.dosen_id', 'left')
                ->join('kelas', 'kelas.id=jadwal.kelas_id', 'left')
                ->join('mengawas', 'jadwal.id=mengawas.jadwal_id', 'left')
                ->join('laboran', 'laboran.id=mengawas.laboran_id', 'left')
                ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'left')
                ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id', 'left')
                ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id', 'left')
                ->where('ta_id', $ta['id'])
                ->where('hari', hari_ini())
                ->where('rooms.mahasiswa_id', $mhs['id'])
                ->orderBy('jam_mulai')->findAll();
        } else {
            $mhs = $this->mhs->where('user_id', session()->get('uid'))->first();
            $data = $this->laboran
                ->select("jadwal.*, matakuliah.nama_matakuliah, matakuliah.semester, 
                mahasiswa.nama_mahasiswa, kelas.kelas, dosen.nama_dosen,
                (SELECT COUNT(rooms.id) FROM rooms where jadwal.id=rooms.jadwal_id) AS jumlah,
                right(jurusan.jurusan,4) as jurusan")
                ->join('mahasiswa', 'mahasiswa.id=laboran.mahasiswa_id', 'left')
                ->join('mengawas', 'mengawas.laboran_id=laboran.id', 'left')
                ->join('jadwal', 'jadwal.id=mengawas.jadwal_id', 'left')
                ->join('dosen', 'dosen.id=jadwal.dosen_id', 'left')
                ->join('kelas', 'kelas.id=jadwal.kelas_id', 'left')
                ->join('matakuliah', 'matakuliah.id=jadwal.matakuliah_id', 'left')
                ->join('jurusan', 'jurusan.id=matakuliah.jurusan_id', 'left')
                ->where('ta_id', $ta['id'])
                ->where('hari', hari_ini())
                ->where('laboran.mahasiswa_id', $mhs['id'])
                ->orderBy('jam_mulai')->findAll();
        }
        return view('home', ['title' => 'Home', 'data' => $data]);
    }
}
