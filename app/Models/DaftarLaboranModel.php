<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarLaboranModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pendaftaran_laboran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mahasiswa_id', 'alasan', 'status'];
}
