<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menu_produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_produk', 'harga', 'deskripsi', 'kategori'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
}
