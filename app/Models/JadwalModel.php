<?php

namespace App\Models;

use CodeIgniter\Model;

class MatkulModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'jadwal';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['hari', 'jam_mulai', 'jam_selesai', 'matakuliah_id', 'laboran_id', 'ta_id', 'kelas_id'];
}
