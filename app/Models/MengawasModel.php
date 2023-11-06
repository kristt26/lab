<?php

namespace App\Models;

use CodeIgniter\Model;

class MengawasModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'mengawas';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['jadwal_id', 'laboran_id'];

    public function getMengawas()
    {
        $conn = \Config\Database::connect();
        $uid = session()->get('uid');
        $ta_id = session()->get('ta_id');
        if (session()->get('role') == 'Laboran') {
            $data = $conn->query("SELECT
            `matakuliah`.`kode`,
            `matakuliah`.`nama_matakuliah`,
            `matakuliah`.`semester`,
            `jurusan`.`jurusan`,
            `jurusan`.`initial`,
            `kelas`.`kelas`,
            `jadwal`.`shift`,
            `mengawas`.`jadwal_id`
            FROM
                `mengawas`
                LEFT JOIN `jadwal` ON `jadwal`.`id` = `mengawas`.`jadwal_id`
                LEFT JOIN `matakuliah` ON `matakuliah`.`id` = `jadwal`.`matakuliah_id`
                LEFT JOIN `laboran` ON `mengawas`.`laboran_id` = `laboran`.`id`
                LEFT JOIN `mahasiswa` ON `laboran`.`mahasiswa_id` = `mahasiswa`.`id`
                LEFT JOIN `jurusan` ON `jurusan`.`id` = `matakuliah`.`jurusan_id`
                LEFT JOIN `kelas` ON `kelas`.`id` = `jadwal`.`kelas_id`
            WHERE mahasiswa.user_id='$uid' AND ta_id='$ta_id'")->getResult();
        }else{
            $data = $conn->query("SELECT
            `matakuliah`.`kode`,
            `matakuliah`.`nama_matakuliah`,
            `matakuliah`.`semester`,
            `jurusan`.`jurusan`,
            `jurusan`.`initial`,
            `kelas`.`kelas`,
            `mengawas`.`jadwal_id`
            FROM
                `mengawas`
                LEFT JOIN `jadwal` ON `jadwal`.`id` = `mengawas`.`jadwal_id`
                LEFT JOIN `matakuliah` ON `matakuliah`.`id` = `jadwal`.`matakuliah_id`
                LEFT JOIN `jurusan` ON `jurusan`.`id` = `matakuliah`.`jurusan_id`
                LEFT JOIN `kelas` ON `kelas`.`id` = `jadwal`.`kelas_id`
                LEFT JOIN `dosen` ON `dosen`.`id` = `jadwal`.`dosen_id`
            WHERE dosen.user_id='$uid' AND jadwal.ta_id='$ta_id'")->getResult();
        }
        return $data;
    }
}
