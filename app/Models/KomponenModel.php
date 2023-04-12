<?php

namespace App\Models;

use CodeIgniter\Model;

class KomponenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'komponen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['komponen', 'persentase', 'ta_id'];
}
