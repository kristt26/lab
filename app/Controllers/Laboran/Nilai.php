<?php

namespace App\Controllers\Laboran;

use App\Controllers\BaseController;
use CodeIgniter\Database\Query;
use PHPUnit\Util\Json;
use CodeIgniter\Database\Exceptions\DatabaseException;

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
    protected $con;

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
        $this->con = \Config\Database::connect();
        helper("find_helper");
    }
    public function index()
    {
        return view('laboran/nilai', ['title' => 'Komponen Penilaian']);
    }

    public function setView($param)
    {
        $string = dekrip($param);
        if ($string[0] == "tugas") {
            return view('laboran/tugas');
        } else if ($string[0] == "uas") {
            return view('laboran/uas');
        }
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
        // $Pertemuan = $this->pertemuan->asObject()->select('pertemuan.*')->join('mengawas', 'mengawas.id=pertemuan.mengawas_id', 'LEFT')
        //     ->where("jadwal_id", $id)->findAll();
        $dataNilai = $this->nilai->select('nilai.*')
            ->join('detail_komponen', 'detail_komponen.id = nilai.detail_komponen_id', 'LEFT')->where('jadwal_id', $id)->findAll();
        $data['komponen'] = $this->detail->where('jadwal_id', $id)->countAllResults() > 0 ?
            $this->komponen->asObject()->select("komponen.*, detail_komponen.id as detail_id, detail_komponen.bobot")
            ->join("detail_komponen", "detail_komponen.komponen_id = komponen.id", "LEFT")
            ->where("jadwal_id = '$id'")->findAll() : $this->komponen->asObject()->findAll();
        $data['mahasiswa'] = $this->rooms->asObject()->select("rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm")
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id')
            ->where("jadwal_id", "$id")->findAll();
        foreach ($data['mahasiswa'] as $keyMhs => $mahasiswa) {
            $mahasiswa->nilai = [];
            $mahasiswa->total = 0;
            // $nilai = false;
            foreach ($data['komponen'] as $keyKom => $komponen) {
                $cKom = false;
                foreach ($dataNilai as $key => $value) {
                    if ($komponen->detail_id == $value['detail_komponen_id'] && $value['rooms_id'] == $mahasiswa->id) {
                        if($komponen->komponen == "UAS"){
                            $item = [
                                "komponen" => $komponen->komponen,
                                "nilai" => $value['nilai'] * ($komponen->bobot/100)
                            ];
                            $mahasiswa->nilai[] = $item;
                            $mahasiswa->total += ($value['nilai'] * ($komponen->bobot/100));
                        }else{
                            $item = [
                                "komponen" => $komponen->komponen,
                                "nilai" => $value['nilai']
                            ];
                            $mahasiswa->total += $value['nilai'];
                            $mahasiswa->nilai[] = $item;
                        }
                        $cKom = true;
                    }
                }
                if ($cKom == false) {
                    $item = [
                        "komponen" => $komponen->komponen,
                        "nilai" => 0
                    ];
                    $mahasiswa->nilai[] = $item;
                }
            }
            $mahasiswa->huruf = penilaian($mahasiswa->total);










            // $nilai = $this->nilai->asObject()->where("rooms_id", $mahasiswa->id)->findAll();
            // if (count($nilai) > 0) {
            //     foreach ($data['komponen'] as $keyKom => $komponen) {
            //         foreach ($nilai as $key => $value) {
            //             if ($komponen->detail_id == $value->detail_komponen_id) {
            //                 $item = [
            //                     "komponen" => $komponen->komponen,
            //                     "nilai" => $value->nilai
            //                 ];
            //                 $mahasiswa->nilai[] = $item;
            //             }
            //         }
            //     }
            // } else {
            //     foreach ($data['komponen'] as $keyKom => $komponen) {
            //         $item = [
            //             "komponen" => $komponen->komponen,
            //             "nilai" => 0
            //         ];
            //         $mahasiswa->nilai[] = $item;
            //     }
            // }
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
        $dataDetailTugas = $this->detailTugas->select("detail_tugas.*")->join('tugas', 'tugas.id=detail_tugas.tugas_id', 'LEFT')->where('jadwal_id', $id)->findAll();
        $dataNilai = $this->nilai->select('nilai.*, detail_komponen.komponen_id')
            ->join('detail_komponen', 'detail_komponen.id = nilai.detail_komponen_id', 'LEFT')->where('jadwal_id', $id)->findAll();
        $absens = $conn->query("SELECT
                        absen.*
                    FROM
                        `absen`
                        LEFT JOIN `pertemuan` ON `absen`.`pertemuan_id` = `pertemuan`.`id`
                        LEFT JOIN `mengawas` ON `pertemuan`.`mengawas_id` = `mengawas`.`id`
                    WHERE jadwal_id = '$id'")->getResult();
        try {
            $conn->transException(true)->transStart();
            foreach ($data['mahasiswa'] as $keyMhs => $mahasiswa) {
                $mahasiswa->nilai = [];
                foreach ($data['komponen'] as $keyKom => $komponen) {
                    if ($komponen->komponen == "Tugas") {
                        $totalNTugas = 0;
                        $jTugas = 0;
                        foreach ($dataDetailTugas as $key => $itemDetail) {
                            if ($itemDetail['rooms_id'] == $mahasiswa->id) {
                                $totalNTugas += $itemDetail['nilai'];
                                $jTugas += 1;
                            }
                        }
                        $cekNTugas = false;
                        $iTugas = null;
                        foreach ($dataNilai as $key => $itemNilai) {
                            if ($itemNilai['rooms_id'] == $mahasiswa->id && $itemNilai['komponen_id'] == $komponen->id) {
                                $cekNTugas = true;
                                $iTugas = $itemNilai;
                            }
                        }
                        if ($cekNTugas == false) {
                            $item = [
                                "detail_komponen_id" => $komponen->detail_id,
                                "rooms_id" => $mahasiswa->id,
                                "nilai" => $totalNTugas > 0 ? ($totalNTugas / $jTugas) * ($komponen->bobot / 100) : 0
                            ];
                            $this->nilai->insert($item);
                            $mahasiswa->nilai[] = $item;
                        } else {
                            $item = [
                                "detail_komponen_id" => $komponen->detail_id,
                                "rooms_id" => $mahasiswa->id,
                                "nilai" => $totalNTugas > 0 ? ($totalNTugas / $jTugas) * ($komponen->bobot / 100) : 0
                            ];
                            $this->nilai->update($iTugas['id'], ['nilai' => $item['nilai']]);
                            $mahasiswa->nilai[] = $item;
                        }
                        //     $mahasiswa->tugas = $conn->query("SELECT tugas.*,
                        //     (select detail_tugas.id FROM detail_tugas WHERE detail_tugas.tugas_id=id AND detail_tugas.rooms_id='$mahasiswa->id') as detail_id,
                        //     (select detail_tugas.nilai FROM detail_tugas WHERE detail_tugas.tugas_id=id AND detail_tugas.rooms_id='$mahasiswa->id') as nilai
                        //   FROM
                        //     `tugas`
                        //   WHERE jadwal_id = '$id'")->getResult();
                        //     $nilaiTugas = $conn->query("SELECT SUM(nilai) as nilai FROM tugas LEFT JOIN detail_tugas ON detail_tugas.tugas_id=tugas.id WHERE jadwal_id = '$id'")->rowData;
                        //     $item = [
                        //         "detail_komponen_id" => $komponen->detail_id,
                        //         "rooms_id" => $mahasiswa->id,
                        //         "nilai" => $nilaiTugas == null ? 0 : ($nilaiTugas / count($mahasiswa->tugas)) * ($komponen->bobot / 100)
                        //     ];
                        //     $this->nilai->insert($item);
                        //     $mahasiswa->nilai[] = $item;
                    } else if ($komponen->komponen == "Kehadiran") {
                        $h = 0;
                        $s = 0;
                        $i = 0;
                        foreach ($absens as $keyAbsn => $absen) {
                            if ($absen->status == "H" && $absen->rooms_id == $mahasiswa->id) $h += 1;
                            else if ($absen->status == "S" && $absen->rooms_id == $mahasiswa->id) $s += 0.5;
                            else if ($absen->status == "I" && $absen->rooms_id == $mahasiswa->id) $i += 0.25;
                        }
                        $cekNAbsen = false;
                        $iAbsen = null;
                        foreach ($dataNilai as $key => $itemNilai) {
                            if ($itemNilai['rooms_id'] == $mahasiswa->id && $itemNilai['komponen_id'] == $komponen->id) {
                                $cekNAbsen = true;
                                $iAbsen = $itemNilai;
                            }
                        }
                        $item = [
                            "detail_komponen_id" => $komponen->detail_id,
                            "rooms_id" => $mahasiswa->id,
                            "nilai" => (($h + $s + $i) / count($Pertemuan) * 100) * ($komponen->bobot / 100)
                        ];
                        if ($cekNAbsen == false) {
                            $this->nilai->insert($item);
                            $mahasiswa->nilai[] = $item;
                        } else {
                            $this->nilai->update($iAbsen['id'], ['nilai' => $item["nilai"]]);
                            $mahasiswa->nilai[] = $item;
                        }
                    } else if ($komponen->komponen == "UAS") {
                        foreach ($dataNilai as $key => $itemNilai) {
                            if ($itemNilai['rooms_id'] == $mahasiswa->id && $itemNilai['komponen_id'] == $komponen->id) {
                                $mahasiswa->nilai[] = $itemNilai;
                            } else {
                                $item = [
                                    "detail_komponen_id" => $komponen->detail_id,
                                    "rooms_id" => $mahasiswa->id,
                                    "nilai" => 0
                                ];
                                $mahasiswa->nilai[] = $item;
                            }
                        }
                        // $dataUas = $uas->asObject()->where('rooms_id', $mahasiswa->id)->first();
                        // $item = [
                        //     "detail_komponen_id" => $komponen->detail_id,
                        //     "rooms_id" => $mahasiswa->id,
                        //     "nilai" => $dataUas == null ? 0 : $dataUas * ($komponen->bobot / 100)
                        // ];
                        // $this->nilai->insert($item);
                        // $mahasiswa->nilai[] = $item;
                    }
                }
            }
            $conn->transComplete();
            return $this->respond($data);
        } catch (DatabaseException $th) {
            return $this->fail($th->getMessage());
        }
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

    public function get_tugas($id)
    {
        $this->tugas = new \App\Models\TugasModel();
        $this->detailTugas = new \App\Models\DetailTugasModel();
        $tugas = $this->tugas->asObject()->where('jadwal_id', $id)->findAll();
        $dataNilai = $this->detailTugas->select('detail_tugas.*, tugas.ke')
            ->join('tugas', 'tugas.id = detail_tugas.tugas_id', 'LEFT')->where('jadwal_id', $id)->findAll();
        $mahasiswa = $this->rooms->asObject()->select('rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm')
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id')
            ->where('jadwal_id', $id)->findAll();
        foreach ($mahasiswa as $key1 => $mhs) {
            $mhs->tugas = [];
            foreach ($tugas as $key2 => $tgs) {
                $cek = false;
                foreach ($dataNilai as $key => $itemNilai) {
                    if ($itemNilai['tugas_id'] == $tgs->id && $itemNilai['rooms_id'] == $mhs->id) {
                        $mhs->tugas[] = [
                            'id' => $itemNilai['id'],
                            'tugas_id' => $itemNilai['tugas_id'],
                            'rooms_id' => $itemNilai['rooms_id'],
                            'nilai' => (int)$itemNilai['nilai'],
                            'ke' => $tgs->ke
                        ];
                        $cek = true;
                    }
                }
                if ($cek == false) {
                    $mhs->tugas[] = [
                        'id' => null,
                        'tugas_id' => $tgs->id,
                        'rooms_id' => $mhs->id,
                        'nilai' => 0,
                        'ke' => $tgs->ke,
                    ];
                }
                // $nilai = $this->tugas->select('detail_tugas.*, tugas.ke')
                //     ->join('detail_tugas', 'detail_tugas.tugas_id=tugas.id', 'LEFT')
                //     ->where("tugas_id", $tgs->id)
                //     ->where('rooms_id', $mhs->id)->first();
                // if (is_null($nilai)) {
                //     $mhs->tugas[] = [
                //         'id' => null,
                //         'tugas_id' => $tgs->id,
                //         'rooms_id' => $mhs->id,
                //         'nilai' => 0,
                //         'ke' => $tgs->ke,
                //     ];
                // } else {
                //     $mhs->tugas[] = [
                //         'id' => $nilai['id'],
                //         'tugas_id' => $nilai['tugas_id'],
                //         'rooms_id' => $nilai['rooms_id'],
                //         'nilai' => (int)$nilai['nilai'],
                //         'ke' => $tgs->ke
                //     ];
                // }
            }
        }
        $data = [];
        $data['tugas'] = $tugas;
        $data['mahasiswa'] = $mahasiswa;
        return $this->respond($data);
    }

    public function get_uas($id)
    {
        $dtNilai = $this->nilai->asObject()->select('nilai.*')->join('detail_komponen', 'detail_komponen.id=nilai.detail_komponen_id')
            ->where('jadwal_id', $id)
            ->where('komponen_id', 5)->findAll();
        $dtMhs = $this->rooms->asObject()->select('rooms.*, mahasiswa.nama_mahasiswa, mahasiswa.npm')
            ->join('mahasiswa', 'mahasiswa.id=rooms.mahasiswa_id')
            ->where('jadwal_id', $id)->findAll();
        $detail = $this->detail->asObject()->where('komponen_id', 5)->where('jadwal_id', $id)->first();
        foreach ($dtMhs as $keyMhs => $mhs) {
            $cek = false;
            foreach ($dtNilai as $keyNilai => $nilai) {
                if($nilai->rooms_id == $mhs->id){
                    $mhs->nilai = $nilai;
                    $mhs->nilai->nilai = (int) $mhs->nilai->nilai;
                    $cek = true;
                }
            }
            if(!$cek){
                $mhs->nilai = ['detail_komponen_id'=>$detail->id, 'rooms_id'=>$mhs->id, 'nilai'=>0];
            }
        }
        return $this->respond($dtMhs);
    }

    public function tambahTugas()
    {
        $id = $this->request->getJSON();
        $this->tugas = new \App\Models\TugasModel();
        $item = [
            'jadwal_id' => $id,
            'ke' => $this->tugas->where('jadwal_id', $id)->countAllResults() + 1
        ];
        $this->tugas->insert($item);
        $item['tugas_id'] = $this->tugas->getInsertID();
        $item['id'] = null;
        $item['nilai'] = 0;
        return $this->respond($item);
    }

    public function postNilai($id)
    {
        $this->detailTugas = new \App\Models\DetailTugasModel();
        $this->tugas = new \App\Models\TugasModel();
        $komponen = $this->detail->asObject()->where('jadwal_id', $id)->where('komponen_id', '3')->first();
        $data = $this->request->getJSON();
        if (is_null($data->id)) {
            if ($this->detailTugas->insert($data)) {
                $data->id = $this->detailTugas->getInsertID();
                $nilaiTugas = (($this->con->query("SELECT sum(nilai) as total from `detail_tugas`
                LEFT JOIN `tugas` ON `tugas`.`id` = `detail_tugas`.`tugas_id` 
                WHERE jadwal_id='$id' AND rooms_id='$data->rooms_id'")->getFirstRow()->total) / ($this->tugas->where('jadwal_id', $id)->countAllResults())) * ($komponen->bobot / 100);
                $this->nilai->where('detail_komponen_id', $komponen->id)->where('rooms_id', $data->rooms_id)->update(null, ['nilai' => $nilaiTugas]);
                return $this->respond($data);
            } else return $this->fail("Error");
        } else {
            if ($this->detailTugas->update($data->id, $data)) {
                $data->id = $this->detailTugas->getInsertID();
                $nilaiTugas = (($this->con->query("SELECT sum(nilai) as total from `detail_tugas`
                LEFT JOIN `tugas` ON `tugas`.`id` = `detail_tugas`.`tugas_id` 
                WHERE jadwal_id='$id' AND rooms_id='$data->rooms_id'")->getFirstRow()->total) / ($this->tugas->where('jadwal_id', $id)->countAllResults())) * ($komponen->bobot / 100);
                $this->nilai->where('detail_komponen_id', $komponen->id)->where('rooms_id', $data->rooms_id)->update(null, ['nilai' => $nilaiTugas]);
                return $this->respond($data);
            } else return $this->fail("Error");
        }
    }

    public function postUas($id)
    {
        $data = $this->request->getJSON();
        if(isset($data->id)){
            $this->nilai->update($data->id, $data);
            return $this->respond($data);
        }else{
            $this->nilai->insert($data);
            $data->id = $this->nilai->getInsertID();
            return $this->respond($data);
        }
    }
}
