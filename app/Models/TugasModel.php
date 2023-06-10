<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tugas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['jadwal_id', 'ke'];
}
