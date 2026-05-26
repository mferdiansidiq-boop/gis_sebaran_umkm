<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUmkm;
use App\Models\ModelWilayah;
use App\Models\ModelSetting;
use CodeIgniter\HTTP\ResponseInterface;

class UMKM extends BaseController
{
    protected $ModelWilayah;
    protected $ModelSetting;
    protected $ModelUmkm;

    public function __construct() 
{
   $this->ModelWilayah = new ModelWilayah();
   $this->ModelSetting = new ModelSetting();
   $this->ModelUmkm = new ModelUmkm();
}
    
    public function index()
    {
        $data = [
            'judul' => 'Umkm',
            'menu' => 'umkm',
            'page' => 'umkm/v_index', 
            'umkm' => $this->ModelUmkm->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

      public function Input()
    {
        $data = [
            'judul' => 'Input Umkm',
            'menu' => 'umkm',
            'page' => 'umkm/v_input',
            'web' => $this->ModelSetting->Dataweb(),
            'provinsi' =>$this->ModelUmkm->allProvinsi(),
             'wilayah' => $this->ModelWilayah->AllData(),
           
        ];
        return view('v_template_back_end', $data);
    }

    //kabupaten
    public function Kabupaten()
    {
        $id_provinsi = $this->request->getPost('id_provinsi');
        $kab = $this->ModelUmkm->allKabupaten($id_provinsi);
        echo '<option value="">--Pilih Kabupaten--</option>';
        foreach ($kab as $key => $value) {
            echo '<option value="' . $value['id_kabupaten'] . '">' . $value['nama_kabupaten'] . '</option>';
        }
    }

    //kabupaten
    public function Kecamatan()
    {
        $id_kabupaten = $this->request->getPost('id_kabupaten');
        $kec = $this->ModelUmkm->allKecamatan($id_kabupaten);
        echo '<option value="">--Pilih Kecamatan--</option>';
        foreach ($kec as $key => $value) {
            echo '<option value="' . $value['id_kecamatan'] . '">' . $value['nama_kecamatan'] . '</option>';
        }
    }
}
