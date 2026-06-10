<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table            = 'pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_pelanggan',
        'id_produk',
        'jumlah',
        'total_harga',
        'status_pesanan',
        'tanggal_pesanan',
        'detail_pesanan'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
}
