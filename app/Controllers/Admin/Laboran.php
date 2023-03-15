<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Laboran extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        return view('admin/laboran', ['title' => 'Laboran']);
    }
    public function store()
    {
        return $this->respond(['Testing' => 'Data']);
    }

    public function read($id = null)
    {
        //
    }

    public function post()
    {
        //
    }

    public function put()
    {
        //
    }

    public function delete($id = null)
    {
    }
}
