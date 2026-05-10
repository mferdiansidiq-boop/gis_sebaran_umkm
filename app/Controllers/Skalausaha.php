<?php

namespace App\Controllers;

use App\Controllers\BaseController;
//use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelSkalausaha;
class SkalaUsaha extends BaseController
{
 protected $ModelSkalausaha;
 public function __construct() 
{
   $this->ModelSkalausaha = new ModelSkalausaha();
}
    public function index()
    {
        $data = [
            'judul' => 'Skalausaha',
            'menu' => 'skalausaha', //variabel menu aktiv
            'page' => 'v_skalausaha', 
            'skalausaha' => $this->ModelSkalausaha->AllData(),
        ];
        return view('v_template_back_end', $data);
    }
}
