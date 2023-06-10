<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailKomponenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_komponen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['komponen_id', 'jadwal_id', 'bobot'];
}
