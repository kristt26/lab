<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\JurusanModel;
use App\Models\TaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    protected $jurusan;
    protected $ta;
    protected $jadwal;
    protected $conn;

    public function __construct()
    {
        $this->jurusan = new JurusanModel();
        $this->ta = new TaModel();
        $this->jadwal = new JadwalModel();
        $this->conn = \Config\Database::connect();
    }

    public function ba()
    {
        $ta = $this->ta->asObject()->where("status", '1')->first();
        $jurusans = $this->jurusan->asObject()->findAll();
        $absen =  $this->conn->query("SELECT
            `absen`.*,
            `rooms`.`jadwal_id`,
            `rooms`.`mahasiswa_id`
        FROM
            `absen`
            LEFT JOIN `rooms` ON `absen`.`rooms_id` = `rooms`.`id`
            LEFT JOIN `jadwal` ON `rooms`.`jadwal_id` = `jadwal`.`id`
        WHERE ta_id = '$ta->id'
        ")->getResultArray();
        foreach ($jurusans as $keyJrsn => $jurusan) {
            $jurusan->matakuliah = $this->jadwal->asObject()->select("jadwal.*, matakuliah.nama_matakuliah, kelas.kelas")
                ->join("matakuliah", "matakuliah.id=jadwal.matakuliah_id", "LEFT")
                ->join("kelas", "kelas.id=jadwal.kelas_id", "LEFT")
                ->where('ta_id', $ta->id)
                ->where('jurusan_id', $jurusan->id)
                ->findAll();
            foreach ($jurusan->matakuliah as $keyMat => $mat) {
                $jadwal_id = $mat->id;
                try {
                    $mat->total = array_count_values(array_column($absen, 'jadwal_id'))[$jadwal_id];
                    //code...
                } catch (\Throwable $th) {
                    $mat->total = 0;
                    //throw $th;
                }
            }
        }
        return view('admin/laporan/ba', ['title' => 'Berita Acara', 'data'=>$jurusans]);
    }

    public function cetak_ba()
    {
        $ta = $this->ta->asObject()->where("status", '1')->first();
        $jurusans = $this->jurusan->asObject()->findAll();
        $absen =  $this->conn->query("SELECT
            `absen`.*,
            `rooms`.`jadwal_id`,
            `rooms`.`mahasiswa_id`
        FROM
            `absen`
            LEFT JOIN `rooms` ON `absen`.`rooms_id` = `rooms`.`id`
            LEFT JOIN `jadwal` ON `rooms`.`jadwal_id` = `jadwal`.`id`
        WHERE ta_id = '$ta->id'
        ")->getResultArray();
        $data = [];
        foreach ($jurusans as $keyJrsn => $jurusan) {
            $jurusan->matakuliah = $this->jadwal->asObject()->select("jadwal.*, matakuliah.nama_matakuliah, kelas.kelas, dosen.nama_dosen")
                ->join("matakuliah", "matakuliah.id=jadwal.matakuliah_id", "LEFT")
                ->join("kelas", "kelas.id=jadwal.kelas_id", "LEFT")
                ->join("dosen", "dosen.id=jadwal.dosen_id", "LEFT")
                ->where('ta_id', $ta->id)
                ->where('jurusan_id', $jurusan->id)
                ->findAll();
            foreach ($jurusan->matakuliah as $keyMat => $mat) {
                $jadwal_id = $mat->id;
                try {
                    $mat->jurusan = $jurusan->jurusan;
                    $mat->total = array_count_values(array_column($absen, 'jadwal_id'))[$jadwal_id];
                    $data[] = $mat;
                    //code...
                } catch (\Throwable $th) {
                    $mat->jurusan = $jurusan->jurusan;
                    $mat->total = 0;
                    $data[] = $mat;
                }
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $setItem = $this->request->getGet("item");
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,],]];
        $sheet->setCellValue('A1', 'LABORATORIUM UNIVERITAS SEPULUH NOPEMBER JAYAPURA');
        $sheet->setCellValue('A2', 'REKAPITULASI BERITA ACARA PRAKTIKUM');
        $sheet->setCellValue('A3', 'TAHUN AJARAN '.$ta->tahun_akademik.' SEMESTER '.strtoupper($ta->semester));
        $spreadsheet->getActiveSheet()->mergeCells("A1:F1");
        $spreadsheet->getActiveSheet()->mergeCells("A2:F2");
        $spreadsheet->getActiveSheet()->mergeCells("A3:F3");
        $sheet->setCellValue('A5', 'NO')
            ->setCellValue('B5', 'JURUSAN')
            ->setCellValue('C5', 'MATAKULIAH')
            ->setCellValue('D5', 'KELAS')
            ->setCellValue('E5', 'DOSEN')
            ->setCellValue('F5', 'TOTAL');
        $spreadsheet->getActiveSheet()->getStyle("A5:F5")->getFont()->setBold(true)->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A2")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A3")->getFont()->setBold(true)->setSize(16);
        $spreadsheet->getActiveSheet()->getStyle("A1:A3")->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setWidth(34, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setWidth(240, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setWidth(251, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setWidth(95, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setWidth(251, 'px');
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setWidth(95, 'px');
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $key + 6, $key + 1)
                ->setCellValue('B' . $key + 6, $value->jurusan)
                ->setCellValue('C' . $key + 6, $value->nama_matakuliah)
                ->setCellValue('D' . $key + 6, $value->kelas)
                ->setCellValue('E' . $key + 6, $value->nama_dosen)
                ->setCellValue('F' . $key + 6, $value->total);
        }
        $spreadsheet->getActiveSheet()->getStyle("A5:F" . count($data) + 5)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . ' rekapitulasi';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
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

    public function put()
    {
        $data = $this->request->getJSON();
        try {
            $this->jurusan->update($data->id, $data);
            return $this->respondUpdated(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $this->jurusan->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
