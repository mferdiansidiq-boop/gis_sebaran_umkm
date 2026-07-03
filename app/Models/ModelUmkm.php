<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUmkm extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_umkm')
            // PERBAIKAN: Beri alias 'as nama_skala' supaya tidak menimpa kolom tbl_umkm.skala_usaha
            ->select('tbl_umkm.*, tbl_skala_usaha.skala_usaha as nama_skala, tbl_kategori_umkm.nama_kategori_umkm')
            
            // Join skala usaha
            ->join('tbl_skala_usaha', 'tbl_skala_usaha.id_skala_usaha = tbl_umkm.skala_usaha', 'left')
            
            // Join kategori umkm
            ->join('tbl_kategori_umkm', 'tbl_kategori_umkm.id_kategori_umkm = tbl_umkm.id_kategori_umkm', 'left')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        return $this->db->table('tbl_umkm')->insert($data);
    }

    public function DetailData($id_umkm)
    {
        return $this->db->table('tbl_umkm')
            // PERBAIKAN: Beri alias 'as nama_skala' supaya tidak menimpa kolom tbl_umkm.skala_usaha
            ->select('tbl_umkm.*, tbl_skala_usaha.skala_usaha as nama_skala, tbl_kategori_umkm.nama_kategori_umkm, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan')
            ->join('tbl_skala_usaha', 'tbl_skala_usaha.id_skala_usaha = tbl_umkm.skala_usaha', 'left')
            ->join('tbl_kategori_umkm', 'tbl_kategori_umkm.id_kategori_umkm = tbl_umkm.id_kategori_umkm', 'left')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_umkm.id_kabupaten', 'left')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_umkm.id_kecamatan', 'left')
            ->where('id_umkm', $id_umkm)
            ->get()->getRowArray();
    }

    public function UpdateData($data)
    {
        return $this->db->table('tbl_umkm')
            ->where('id_umkm', $data['id_umkm'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        return $this->db->table('tbl_umkm')
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