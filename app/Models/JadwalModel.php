<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'jadwal';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['hari', 'jam_mulai', 'jam_selesai', 'ruang',  'matakuliah_id', 'ta_id', 'kelas_id', 'shift', 'dosen_id','kapasitas'];
}
