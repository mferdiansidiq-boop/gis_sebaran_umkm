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
}
