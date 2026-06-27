<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUmkm extends Model
{
   public function AllData()
{
    return $this->db->table('tbl_umkm')
    ->join('tbl_skala_usaha', 'tbl_skala_usaha.id_skala_usaha = tbl_umkm.skala_usaha', 'left')
    ->get()->getResultArray();
}

   public function InsertData($data)
   {
        return $this->db->table('tbl_umkm')->insert($data);
   }

   public function DetailData($id_umkm)
{
    return $this->db->table('tbl_umkm')
    ->join('tbl_skala_usaha', 'tbl_skala_usaha.id_skala_usaha = tbl_umkm.skala_usaha', 'left')
    ->where('id_umkm', $id_umkm)
    ->get()->getRowArray();
}

   public function UpdateData($data)
   {
       $this->db->table('tbl_umkm')
             ->where('id_umkm', $data['id_umkm'])
             ->update($data);
   }

   public function DeleteData($data)
   {
       $this->db->table('tbl_umkm')
             ->where('id_umkm', $data['id_umkm'])
             ->delete($data);
   }

   //provinsi
   public function allProvinsi()
   {
     return $this->db->table('tbl_provinsi')
       ->orderBy('id_provinsi', 'ASC')
       ->get()->getResultArray();
   }

   public function allKabupaten($id_provinsi)
   {
    return $this->db->table('tbl_kabupaten')
       ->where('id_provinsi', $id_provinsi)
       ->get()->getResultArray();
   }

    public function allKecamatan($id_kabupaten)
   {
    return $this->db->table('tbl_kecamatan')
       ->where('id_kabupaten', $id_kabupaten)
       ->get()->getResultArray();
   }


}
