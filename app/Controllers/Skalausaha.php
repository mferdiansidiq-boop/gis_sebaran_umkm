<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SkalaUsaha extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Skalausaha',
            'menu' => 'skalausaha', //variabel menu aktiv
            'page' => 'v_skalausaha', 
        ];
        return view('v_template_back_end', $data);
    }
}
