<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelWilayah;
use App\Models\ModelKategoriumkm; // 1. Ubah ke ModelKategoriumkm

class Home extends BaseController
{
    protected $ModelSetting;
    protected $ModelWilayah;
    protected $ModelKategoriumkm; // 2. Ubah ke ModelKategoriumkm
    
    public function __construct() 
    {
       $this->ModelSetting = new ModelSetting();
       $this->ModelWilayah = new ModelWilayah();
       $this->ModelKategoriumkm = new ModelKategoriumkm(); // 3. Ubah ke ModelKategoriumkm
    }

    public function index()
    {
        $data = [
            'judul'    => 'Home',
            'page'     => 'v_home',
            'web'      => $this->ModelSetting->Dataweb(),
            'wilayah'  => $this->ModelWilayah->AllData(),
            'kategori' => $this->ModelKategoriumkm->AllData(), // 4. Ambil data kategori (Pastikan di ModelKategoriumkm ada fungsi AllData)
        ];
        return view('v_template_front_end', $data);
    }

    public function wilayah($id_wilayah)
{
    $data = [
        'judul'        => 'Detail Wilayah',
        'page'         => 'v_wilayah_detail', // Kita akan buat file view baru khusus fokus wilayah
        'web'          => $this->ModelSetting->Dataweb(),
        'wilayah'      => $this->ModelWilayah->AllData(), // Tetap dipanggil agar dropdown atas tidak kosong
        'kategori'     => $this->ModelKategoriumkm->AllData(),
        'detail_wil'   => $this->ModelWilayah->DetailData($id_wilayah), // Mengambil 1 data kecamatan terpilih
    ];
    return view('v_template_front_end', $data);
}

public function kategori($id_kategori)
    {
        $data = [
            'judul'     => 'Data UMKM',
            'page'      => 'v_kategori_detail',
            'web'       => $this->ModelSetting->Dataweb(),
            'wilayah'   => $this->ModelWilayah->AllData(),
            'kategori'  => $this->ModelKategoriumkm->AllData(),
            'umkm'      => $this->ModelUmkm->DataByKategori($id_kategori),
        ];
        return view('v_template_front_end', $data);
    }
}