<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Login extends BaseController
{
    use ResponseTrait;
    protected $jurusan;

    public function __construct()
    {
    }
    public function index()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function store()
    {
        return $this->respond($this->jurusan->findAll());
    }

    public function read($id = null)
    {
        return $this->respond($this->jurusan->find($id));
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->jurusan->insert($data);
            $data->id = $this->jurusan->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}