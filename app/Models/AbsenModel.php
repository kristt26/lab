<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'absen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['rooms_id', 'status', 'tgl', 'by', 'pertemuan_id'];
}
