<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        return view('profile');
    }

    function store()
    {
        $mhs = new MahasiswaModel();
        return $this->respond($mhs->select('mahasiswa.*, jurusan.jurusan, kelas.kelas')
            ->join('jurusan', 'jurusan.id=mahasiswa.jurusan_id', 'LEFT')
            ->join('kelas', 'kelas.id=mahasiswa.kelas_id', 'LEFT')
            ->where('user_id', session()->get('uid'))->first());
    }

    function read()
    {
        $kelas = new KelasModel();
        $jurusan = new JurusanModel();
        return $this->respond([
            'jurusans' => $jurusan->findAll(),
            'kelass' => $kelas->findAll()
        ]);
    }

    public function put()
    {
        $mhs = new MahasiswaModel();
        $data = $this->request->getJSON();
        try {
            $mhs->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function reset($status = null)
    {
        $data = $this->request->getJSON();
        $user = new UserModel();
        $conn = \Config\Database::connect();
        try {
            $conn->transBegin();
            $dataUser = $user->asObject()->where('id', session()->get('uid'))->first();
            if (password_verify($data->oldPassword, $dataUser->password)) {
                if($data->oldPassword == $data->newPassword) throw new \Exception("Password baru tidak boleh sama dengan yang lama", 1);
                else $user->update(session()->get('uid'), ['password'=>password_hash($data->newPassword,PASSWORD_DEFAULT), 'change'=>'1']);
                if ($conn->transStatus()) {
                    $conn->transCommit();
                    session()->destroy();
                    return $this->respondUpdated(true);
                } else throw new \Exception("Gagal simpan", 1);
            }else throw new \Exception("Password Lama salah", 1);
            
        } catch (\Throwable $th) {
            $conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }
}
