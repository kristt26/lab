<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\MatkulModel;
use App\Models\JurusanModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Dosen extends BaseController
{
    protected $dosen;
    protected $matakuliah;
    protected $jurusan;
    protected $user;
    protected $role;

    public function __construct()
    {
        $this->dosen = new DosenModel();
        $this->matakuliah = new MatkulModel();
        $this->jurusan = new JurusanModel();
        $this->user = new UserModel();
        $this->role = new UserRoleModel();
    }
    public function index()
    {
        return view('admin/dosen', ['title' => 'Dosen']);
    }

    public function store()
    {
        $dosen = $this->dosen->asObject()->findAll();
        return $this->respond($dosen);
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $conn = \Config\Database::connect();
        try {
            $conn->transBegin();
            $this->user->insert(['username'=>$data->nidn, 'password'=>password_hash($data->nidn,PASSWORD_DEFAULT)]);
            $data->user_id = $this->user->getInsertID();
            $this->role->insert(['user_id'=>$data->user_id, 'role_id'=>4]);
            $this->dosen->insert(['nidn'=>$data->nidn, 'nama_dosen'=>$data->nama_dosen, 'user_id'=>$data->user_id]);
            $data->id = $this->dosen->getInsertID();
            if($conn->transStatus()){
                $conn->transCommit();
                return $this->respond($data);
            }else throw new \Exception("Gagal simpan", 1);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->user->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function reset()
    {
        $data = $this->request->getJSON();
        $conn = \Config\Database::connect();
        try {
            if($data->user_id=='0'){
                $conn->transBegin();
                $this->user->insert(['username'=>$data->nidn, 'password'=>password_hash('Usn@1011',PASSWORD_DEFAULT)]);
                $data->user_id = $this->user->getInsertID();
                $user = ['user_id'=>$data->user_id, 'role_id'=>'4'];
                $this->role->insert($user);
                $this->dosen->update($data->id, ['user_id'=>$data->user_id]);
                if($conn->transStatus()){
                    $conn->transCommit();
                    return $this->respondUpdated(true);
                }else throw new \Exception("Gagal simpan", 1);
            }else{
                $this->user->update($data->user_id, ['password'=>password_hash('Usn@1011',PASSWORD_DEFAULT)]);
                return $this->respondUpdated(true);
            }
        } catch (\Throwable $th) {
            $conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->user->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
