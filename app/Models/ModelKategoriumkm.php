<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategoriumkm extends Model
{
    // Mengambil semua data kategori dari tabel tbl_kategori_umkm
    public function AllData()
    {
        return $this->db->table('tbl_kategori_umkm')
            ->get()->getResultArray();
    }
}