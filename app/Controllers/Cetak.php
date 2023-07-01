<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cetak extends BaseController
{
    public function index()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'WIJK/KSP')
            ->setCellValue('C3', 'KODE KK')
            ->setCellValue('D3', 'NAMA LENGKAP')
            ->setCellValue('E3', 'JENIS KELAMIN')
            ->setCellValue('F3', 'TEMPAT LAHIR')
            ->setCellValue('G3', 'TANGGAL LAHIR')
            ->setCellValue('H3', 'GOLONGAN DARAH')
            ->setCellValue('I3', 'STATUS KAWIN')
            ->setCellValue('J3', 'HUBUNGAN KELUARGA')
            ->setCellValue('K3', 'PENDIDIKAN TERAKHIR')
            ->setCellValue('L3', 'GELAR')
            ->setCellValue('M3', 'PEKERJAAN')
            ->setCellValue('N3', 'ASAL GEREJA')
            ->setCellValue('O3', 'NAMA AYAH')
            ->setCellValue('P3', 'NAMA IBU')
            ->setCellValue('Q3', 'SUKU')
            ->setCellValue('R3', 'STATUS DOMISILI')
            ->setCellValue('S3', 'UNSUR')
            ->setCellValue('T3', 'KEPALA KELUARGA')
            ->setCellValue('U3', 'UMUR')
            ->setCellValue('V3', 'DISABILITAS')
            ->setCellValue('W3', 'BARKOBA')
            ->setCellValue('X3', 'NIKAH GEREJA');
        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-meninggal';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
