<?php

namespace App\Controllers;

use CodeIgniter\Database\Exceptions\DatabaseException;

class Pc extends BaseController
{
    public function index()
    {
        return view('get_mac');
    }

    public function post()
    {
        $data = $this->request->getJSON();
        $db = \Config\Database::connect();
        try {
            $db->transException(true)->transStart();
            $db->table('mac')->insert($data);
            $db->transComplete();
            return $this->respondCreated(true);
        } catch (DatabaseException $e) {
            return $this->fail($e->getCode());
        }
        return view('get_mac');
    }
}
