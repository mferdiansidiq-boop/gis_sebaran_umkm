<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWilayah;
use App\Models\ModelSetting;

class Wilayah extends BaseController
{
    protected $ModelWilayah;
    protected $ModelSetting;

    public function __construct() 
{
   $this->ModelWilayah = new ModelWilayah();
   $this->ModelSetting = new ModelSetting();
}
    public function index()
    {
        $data = [
            'judul' => 'Wilayah',
            'page' => 'wilayah/v_index',
            'wilayah' => $this->ModelWilayah->AllData(),
            'web' => $this->ModelSetting->Dataweb(),
        ];
        return view('v_template_back_end', $data);
    
    }

    public function Input()
    {
        $data = [
            'judul' => 'Input Wilayah',
            'page' => 'wilayah/v_input',
        ];
        return view('v_template_back_end', $data);
    
    }

    public function InsertData()
    {

    

   if ($this->validate([
    'nama_wilayah' => [
        'label' =>'Nama Wilayah',
        'rules' =>'required',
        'errors' => [
            'required' => '{field} Wajib Diisi !!'
         ]
       ],
    'geojson' => [
        'label' =>'GeoJSON',
        'rules' =>'required',
        'errors' => [
            'required' => '{field} Wajib Diisi !!'
         ]
       ],
    'warna' => [
        'label' =>'Warna',
        'rules' =>'required',
        'errors' => [
            'required' => '{field} Wajib Diisi !!'
         ]
       ],
     ])) { 
             
         //jika validasi berhasil
          $data = [
              'nama_wilayah' => $this->request->getPost('nama_wilayah'),
              'warna' => $this->request->getPost('warna'),
              'geojson' => $this->request->getPost('geojson'),
          ];

          $this->ModelWilayah->InsertData($data);
          session()->setFlashdata('insert','Data Berhasil Ditambahkan!!');
          return redirect()->to('Wilayah');
     } else {
         //jika validasi gagal
        
        session()->setFlashdata('errors',\Config\Services::validation()->geterrors());
        return redirect()->to('Wilayah/Input')->withInput('validations',\Config\Services::validation());

     }
    
    }
        
    
}
