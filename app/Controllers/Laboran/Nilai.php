<?php

namespace App\Controllers\Laboran;

use App\Controllers\BaseController;
use CodeIgniter\Database\Query;

class Nilai extends BaseController
{
    protected $komponen;
    protected $detail;
    protected $ta;
    protected $mengawas;
    protected $rooms;
    protected $tugas;
    protected $detailTugas;
    protected $pertemuan;
    protected $absen;
    protected $nilai;

    public function __construct()
    {
        $this->komponen = new \App\Models\KomponenModel();
        $this->detail = new \App\Models\DetailKomponenModel();
        $this->ta = new \App\Models\TaModel();
        $this->rooms = new \App\Models\KontrakModel();
        $this->mengawas = new \App\Models\MengawasModel();
        $this->pertemuan = new \App\Models\PertemuanModel();
        $this->absen = new \App\Models\AbsenModel();
        $this->nilai = new \App\Models\NilaiModel();
    }
    public function index()
    {
        return view('laboran/nilai', ['title' => 'Komponen Penilaian']);
    }

    public function store()
    {
        return $this->respond($this->mengawas->getMengawas());
    }

    public function read($id = null)
    {
        $conn = \Config\Database::connect();
        $this->tugas = new \App\Models\TugasModel();
        $this->detailTugas = new \App\Models\DetailTugasModel();
        $data = [];
        $Pertemuan = $this->pertemuan->asObject()->select('pertemuan.*')->join('mengawas', 'mengawas.id=pertemuan.mengawas_id', 'LEFT')
        ->where("jadwal_id", $id)->findAll();
        $data['komponen'] = $this->detail->where('jadwal_id', $id)->countAllResults() > 0 ?
            $this->komponen->asObject()->select("komponen.*, detail_komponen.id as detail_id, detail_komponen.bobot")
            ->join("detail_komponen", "detail_komponen.komponen_id = komponen.id", "LEFT")
            ->where("jadwal_id = '$id'")->findAll() : $this->komponen->asObject()->findAll();
        $data['mahasiswa'] = $this->rooms->asObject()->select("rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm")
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id')
            ->where("jadwal_id", "$id")->findAll();
        foreach ($data['mahasiswa'] as $keyMhs => $mahasiswa) {
            $mahasiswa->nilai = [];
            if(isset($data['komponen'][0]->bobot)){
                $nilai = $this->nilai->asObject()->where("rooms_id", $mahasiswa->id)->findAll();
                foreach ($data['komponen'] as $keyKom => $komponen) {
                    foreach ($nilai as $key => $value) {
                        if($komponen->detail_id==$value->detail_komponen_id){
                            $item = [
                                "komponen" => $komponen->komponen,
                                "nilai" => $value->nilai
                            ];
                        }
                    }
                    $mahasiswa->nilai[] = $item;
                }
            }else{
                foreach ($data['komponen'] as $keyKom => $komponen) {
                    $item = [
                        "komponen" => $komponen->komponen,
                        "nilai" => 0
                    ];
                    $mahasiswa->nilai[] = $item;
                }
            }
        }
        return $this->respond($data);
    }

    public function set($id = null)
    {
        $conn = \Config\Database::connect();
        $this->tugas = new \App\Models\TugasModel();
        $this->detailTugas = new \App\Models\DetailTugasModel();
        $data = [];
        $Pertemuan = $this->pertemuan->asObject()->select('pertemuan.*')->join('mengawas', 'mengawas.id=pertemuan.mengawas_id', 'LEFT')
        ->where("jadwal_id", $id)->findAll();
        $data['komponen'] = $this->detail->where('jadwal_id', $id)->countAllResults() > 0 ?
            $this->komponen->asObject()->select("komponen.*, detail_komponen.id as detail_id, detail_komponen.bobot")
            ->join("detail_komponen", "detail_komponen.komponen_id = komponen.id", "LEFT")
            ->where("jadwal_id = '$id'")->findAll() : $this->komponen->asObject()->findAll();
        $data['mahasiswa'] = $this->rooms->asObject()->select("rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm")
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id')
            ->where("jadwal_id", "$id")->findAll();
        foreach ($data['mahasiswa'] as $keyMhs => $mahasiswa) {
            $mahasiswa->nilai = [];
            foreach ($data['komponen'] as $keyKom => $komponen) {
                if ($komponen->komponen == "Tugas") {
                    $mahasiswa->tugas = $conn->query("SELECT tugas.*,
                    (select detail_tugas.id FROM detail_tugas WHERE detail_tugas.tugas_id=id AND detail_tugas.rooms_id='$mahasiswa->id') as detail_id,
                    (select detail_tugas.nilai FROM detail_tugas WHERE detail_tugas.tugas_id=id AND detail_tugas.rooms_id='$mahasiswa->id') as nilai
                  FROM
                    `tugas`
                  WHERE jadwal_id = '$id'")->getResult();
                    $nilaiTugas = $conn->query("SELECT SUM(nilai) as nilai FROM tugas LEFT JOIN detail_tugas ON detail_tugas.tugas_id=tugas.id WHERE jadwal_id = '$id'")->rowData;
                    $item = [
                        "detail_komponen_id" => $komponen->detail_id,
                        "rooms_id" => $mahasiswa->id,
                        "nilai" => $nilaiTugas == null ? 0 : ($nilaiTugas / count($mahasiswa->tugas)) * ($komponen->bobot / 100)
                    ];
                    $this->nilai->insert($item);
                    $mahasiswa->nilai[] = $item;
                } else if ($komponen->komponen == "Kehadiran") {
                    $h = 0;
                    $s = 0;
                    $i = 0;
                    $absens = $conn->query("SELECT
                        `absen`.`status`
                    FROM
                        `absen`
                        LEFT JOIN `pertemuan` ON `absen`.`pertemuan_id` = `pertemuan`.`id`
                        LEFT JOIN `mengawas` ON `pertemuan`.`mengawas_id` = `mengawas`.`id`
                    WHERE jadwal_id = '$id' AND rooms_id ='$mahasiswa->id'")->getResult();
                    foreach ($absens as $keyAbsn => $absen) {
                        if ($absen->status == "H") $h += 1;
                        else if ($absen->status == "S") $s += 0.5;
                        else if ($absen->status == "I") $i += 0.25;
                    }
                    $item = [
                        "detail_komponen_id" => $komponen->detail_id,
                        "rooms_id" => $mahasiswa->id,
                        "nilai" => (($h + $s + $i) / count($Pertemuan) * 100) * ($komponen->bobot / 100)
                    ];
                    $this->nilai->insert($item);
                    $mahasiswa->nilai[] = $item;
                } else if ($komponen->komponen == "UAS"){
                    $uas = new \App\Models\UasModel();
                    $dataUas = $uas->asObject()->where('rooms_id', $mahasiswa->id)->first();
                    $item = [
                        "detail_komponen_id" => $komponen->detail_id,
                        "rooms_id" => $mahasiswa->id,
                        "nilai" => $dataUas == null ? 0 : $dataUas * ($komponen->bobot / 100)
                    ];
                    $this->nilai->insert($item);
                    $mahasiswa->nilai[] = $item;
                }
            }
        }
        return $this->respond($data);
    }

    public function post()
    {
        $conn = \Config\Database::connect();
        $data = $this->request->getJSON();
        try {
            $conn->transBegin();
            foreach ($data as $key => $value) {
                if (isset($value->detail_id)) {
                    $this->detail->update($value->detail_id, ['bobot' => $value->bobot]);
                } else {
                    $item = ['komponen_id' => $value->id, 'jadwal_id' => $value->jadwal_id, 'bobot' => $value->bobot];
                    $this->detail->insert($item);
                    $value->detail_id = $this->detail->getInsertID();
                }
            }
            if ($conn->transStatus()) {
                $conn->transCommit();
                return $this->respondCreated($data);
            } else throw new \Exception("Berhasil", 1);
        } catch (\Throwable $th) {
            $conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->komponen->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->komponen->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
