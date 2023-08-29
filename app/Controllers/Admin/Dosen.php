<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\MatkulModel;
use App\Models\JurusanModel;

class Dosen extends BaseController
{
    protected $dosen;
    protected $matakuliah;
    protected $jurusan;

    public function __construct()
    {
        $this->dosen = new DosenModel();
        $this->matakuliah = new MatkulModel();
        $this->jurusan = new JurusanModel();
    }
    public function index()
    {
        return view('admin/matakuliah', ['title' => 'Matakuliah']);
    }

    public function store()
    {
        $jurusans = $this->jurusan->asObject()->findAll();
        foreach ($jurusans as $key => $jurusan) {
            $jurusan->matakuliah = $this->matakuliah->where('jurusan_id', $jurusan->id)->findAll();
        }
        return $this->respond($jurusans);
    }

    public function read($id = null)
    {
        return $this->respond($this->matakuliah->find($id));
    }

    public function by_jurusan($id = null)
    {
        return $this->respond($this->matakuliah->where('jurusan_id', $id)->findAll());
    }

    public function post()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_PORT => "3003",
            CURLOPT_URL => "http://localhost:3003/ws/live2.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"act\":\"GetListDosen\",\n    \"token\":\"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZF9wZW5nZ3VuYSI6ImE2YmFkMTAyLTZjMTUtNDc3Ni04N2I0LTlkMjc4YmNjOTc5YSIsInVzZXJuYW1lIjoiMTQzMDIzIiwibm1fcGVuZ2d1bmEiOiJTVE1JSyBTRVBVTFVIIE5PUEVNQkVSIEpBWUFQVVJBIiwidGVtcGF0X2xhaGlyIjoiIiwidGdsX2xhaGlyIjoiMTg5OS0xMi0zMVQxNDozNzoxMi4wMDBaIiwiamVuaXNfa2VsYW1pbiI6IlAiLCJhbGFtYXQiOiIiLCJ5bSI6IiIsInNreXBlIjoiIiwibm9fdGVsIjoiIiwibm9faHAiOiIiLCJhcHByb3ZhbF9wZW5nZ3VuYSI6IjEiLCJhX2FrdGlmIjoiMSIsInRnbF9nYW50aV9wd2QiOm51bGwsImlkX3NkbV9wZW5nZ3VuYSI6bnVsbCwiaWRfcGRfcGVuZ2d1bmEiOm51bGwsImlkX3dpbCI6Ijk5OTk5OSAgIiwibGFzdF91cGRhdGUiOiIyMDE3LTEwLTI3VDAxOjA0OjA0Ljc0MFoiLCJzb2Z0X2RlbGV0ZSI6IjAiLCJsYXN0X3N5bmMiOiIyMDIzLTA1LTMxVDA1OjI2OjI2LjMxNFoiLCJpZF91cGRhdGVyIjoiZmJlYzBlZGQtYjc5Ni00Y2ZmLWFiMGItYWNkODBhZTUwNzdkIiwiY3NmIjoiLTk4MTkzNjQxNCIsInRva2VuX3JlZyI6bnVsbCwiamFiYXRhbiI6bnVsbCwidGdsX2NyZWF0ZSI6IjE5NjktMTItMzFUMTU6MDA6MDAuMDAwWiIsImlkX3BlcmFuIjozLCJubV9wZXJhbiI6IkFkbWluIFBUIiwiaWRfc3AiOiIxNGEyNzU5YS1jZTgzLTQ4ZWItODVjOS1kYjRmOGRlMDBmMjAiLCJpYXQiOjE2ODg2MjAxODksImV4cCI6MTY4ODYyMTk4OX0.2H9mwIOvFuexOHGDJ1nn52u4fUXvs1-qbQBLyXPp-sI\",\n    \"filter\":\"id_status_aktif='1'\",\n    \"order\":\"\",\n    \"limit\":\"\",\n    \"offset\":\"0\"\n}",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
            $this->dosen->insertBatch($data->data);
            echo $data;
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->matakuliah->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->matakuliah->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
