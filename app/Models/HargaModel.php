<?php

namespace App\Models;

use CodeIgniter\Model;

class HargaModel extends Model{
    protected $table = 'list_harga';
    // protected $useTimestamps = true;
    protected $allowedFields = ['id','name','price', 'last_update'];
    public function Cari($q='')
    {
        $this->select('*');
        $this->where('name','buku');
        return $this->get()->result();
    }
}