<?php

namespace App\Models;

use CodeIgniter\Model;

class LaboranModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'laboran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mahasiswa_id'];
}
