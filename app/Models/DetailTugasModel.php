<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTugasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_tugas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tugas_id', 'rooms_id', 'nilai'];
}
