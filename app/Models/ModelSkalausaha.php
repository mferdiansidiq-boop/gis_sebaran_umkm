<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSkalausaha extends Model
{
   public function AllData()
   {
       return $this->db->table('tbl_skala_usaha')
       ->get()->getResultArray();
   }

   public function InsertData($data)
   {
        return $this->db->table('tbl_skala_usaha')->insert($data);
   }

   public function DetailData($id_skala_usaha)
   {
       return $this->db->table('tbl_skala_usaha')
       ->where('id_skala_usaha',$id_skala_usaha)
       ->get()->getRowArray();
   }

   public function UpdateData($data)
   {
       $this->db->table('tbl_skala_usaha')
             ->where('id_skala_usaha', $data['id_skala_usaha'])
             ->update($data);
   }

   public function DeleteData($data)
   {
       $this->db->table('tbl_skala_usaha')
             ->where('id_skala_usaha', $data['id_skala_usaha'])
             ->delete($data);
   }


}
