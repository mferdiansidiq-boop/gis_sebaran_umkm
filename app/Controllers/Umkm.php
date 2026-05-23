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

     

}
