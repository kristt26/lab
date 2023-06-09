<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'modul';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['judul', 'modul', 'matakuliah_id', 'status'];

}
