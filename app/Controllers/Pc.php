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

    public function version()
    {
        $conn = \Config\Database::connect();
        $version = $conn->query("SELECT version FROM version order by version DESC Limit 1")->getRow();
        return $this->respond($version);
    }
    public function set_version($version)
    {
        $conn = \Config\Database::connect();
        try {
            $version = $conn->query("INSERT INTO version value('$version')");
            return $this->respondCreated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }


}
