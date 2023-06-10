<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\JurusanModel;
use App\Models\UserModel;

class Mahasiswa extends BaseController
{
    protected $mahasiswa;
    protected $jurusan;
    protected $user;
    protected $conn;

    public function __construct()
    {
        $this->mahasiswa = new MahasiswaModel();
        $this->jurusan = new JurusanModel();
        $this->user = new UserModel();
        $this->conn = \Config\Database::connect();
    }
    public function index()
    {
        return view('admin/mahasiswa', ['title' => 'Mahasiswa']);
    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        foreach ($jurusans as $key => $jurusan) {
            $jurusan->mahasiswa = $this->mahasiswa
            ->select("mahasiswa.*, kelas.kelas")
            ->join('kelas', 'kelas.id=mahasiswa.kelas_id')
            ->where('jurusan_id', $jurusan->id)
            ->findAll();
        }
        $data = [
            'jurusan'=>$jurusans,
        ];
        return $this->respond($data);
    }

    public function read($id = null)
    {
        return $this->respond($this->mahasiswa->find($id));
    }

        public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $user = [
                'username' => $data->npm,
                'password' => password_hash($data->npm, PASSWORD_DEFAULT)
            ];
            $this->user->insert($user);
            $user_id = $this->user->getInsertID();
            $this->conn->table('userrole')->insert(['user_id' => $user_id, 'role_id' => '2']);
            $this->mahasiswa->update($data->id, ['user_id'=>$user_id, 'status'=>'1']);
            if($this->conn->transStatus()){
                $this->conn->transCommit();
                return $this->respondUpdated($user_id);
            }else{
                $this->conn->transRollback();
                return $this->fail("Proses Gagal");
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    
    public function delete($id = null)
    {
        try {
            $this->mahasiswa->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
