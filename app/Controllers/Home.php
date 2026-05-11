<?php
 

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelWilayah;

class Home extends BaseController
{
    protected $ModelSetting;
    protected $ModelWilayah;
    public function __construct() 
{
   $this->ModelSetting = new ModelSetting();
   $this->ModelWilayah = new ModelWilayah();
}

    public function index()
    {
        $data = [
            'judul' => 'Home',
            'page' => 'v_home',
            'web' => $this->ModelSetting->Dataweb(),
            'wilayah' => $this->ModelWilayah->AllData(),
        ];
        return view('v_template_front_end', $data);
    }
}
