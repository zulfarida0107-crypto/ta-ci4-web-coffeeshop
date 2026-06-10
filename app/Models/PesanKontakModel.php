<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanKontakModel extends Model
{
    protected $table            = 'pesan_kontak';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'email', 'subjek', 'pesan', 'tanggal_dikirim'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
}
