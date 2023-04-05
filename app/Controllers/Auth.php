<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class auth extends BaseController
{
    use ResponseTrait;
    protected $user;
    protected $kelas;
    protected $db;

    public function __construct()
    {
        $this->user = new \App\Models\UserModel();
        $this->kelas = new \App\Models\KelasModel();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if ($this->user->countAllResults() == 0) {
            try {
                $this->db->transBegin();
                $role = [['id' => '1', 'role' => 'Admin'], ['id' => '2', 'role' => 'Mahasiswa'], ['id' => '3', 'role' => 'Laboran']];
                $this->db->table('role')->insertBatch($role);
                $this->db->table('user')->insert(['id' => '1', 'username' => 'Administrator', 'password' => password_hash('Administrator#1', PASSWORD_DEFAULT)]);
                $this->db->table('userrole')->insert(['user_id' => '1', 'role_id' => '1']);
                if ($this->db->transStatus()) {
                    $this->db->transCommit();
                } else {
                    $this->db->transRollback();
                }
            } catch (\Throwable $th) {
                $this->db->transRollback();
            }
        }
        return view('auth/login', ['title' => 'Login']);
    }

    public function login()
    {
        $data = $this->request->getJSON();
        $user = $this->user->where('user.username', $data->username)->first();
        if (!is_null($user)) {
            if (password_verify($data->password, $user['password'])) {
                $role = $this->db->table('userrole')->select('role.*')
                    ->join('role', 'role.id = userrole.role_id')
                    ->where('user_id', $user['id'])->get()->getResultArray();
                $mahasiswa = $this->db->table('mahasiswa')->where('user_id', $user['id'])->get()->getRow();
                if (count($role) <= 1) {
                    $sessi = [
                        'uid' => $user['id'],
                        'nama' => $role[0]['role'] == 'Admin'?'Administrator':$mahasiswa->nama_mahasiswa,
                        'role' => $role[0]['role'],
                        'is_login' => true
                    ];
                    session()->set($sessi);
                    return $this->respond($role);
                } else if(count($role)>1) {
                    $sessi = [
                        'uid' => $user['id'],
                        'nama' => $mahasiswa->nama_mahasiswa,
                    ];
                    session()->set($sessi);
                    return $this->respond($role);
                }
            } else {
                return $this->fail('Password tidak sesuai');
            }
        } else {
            return $this->fail('User tidak ditemukan');
        }
    }

    public function setrole()
    {
        $data = $this->request->getJSON();
        $role = ['role' => $data->role, 'is_login' => true];
        session()->set($role);
        return $this->respond(true);
    }

    public function register()
    {
        return view('auth/regis');
    }

    public function getdataregis()
    {
        $jurusan = new \App\Models\JurusanModel();
        $data = [
            "jurusan" => $jurusan->findAll(),
            "kelas" => $this->kelas->findAll()
        ];
        return $this->respond($data);
    }

    public function daftar()
    {
        $mahasiswa =  new \App\Models\MahasiswaModel();
        $data = $this->request->getJSON();
        $data->status = '0';
        try {
            if ($mahasiswa->where('npm', $data->npm)->countAllResults() == 0) {
                $mahasiswa->insert($data);
                return $this->respondCreated(true);
            } else {
                return $this->fail("NPM yang anda masukkan sudah terdaftar");
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
