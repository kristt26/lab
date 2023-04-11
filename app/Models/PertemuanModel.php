<?php

namespace App\Models;

use CodeIgniter\Model;

class PertemuanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pertemuan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mengawas_id', 'tgl','pertemuan', 'status'];
}
