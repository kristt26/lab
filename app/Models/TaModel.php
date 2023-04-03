<?php

namespace App\Models;

use CodeIgniter\Model;

class TaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tahun_akademik', 'semester', 'status'];
}
