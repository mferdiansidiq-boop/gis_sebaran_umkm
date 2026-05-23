<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUmkm extends Model
{
   public function AllData()
   {
       return $this->db->table('tbl_umkm')
       ->get()->getResultArray();
   }

   public function InsertData($data)
   {
        return $this->db->table('tbl_umkm')->insert($data);
   }

   public function DetailData($id_umkm)
   {
       return $this->db->table('tbl_umkm')
       ->where('id_umkm',$id_umkm)
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


}
