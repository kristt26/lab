<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama_mahasiswa', 'npm', 'kontak', 'email','alamat', 'user_id', 'kelas_id', 'status', 'jurusan_id', 'photo'];
}
