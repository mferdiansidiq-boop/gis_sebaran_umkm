<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UMKM extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Umkm',
            'menu' => 'umkm',
            'page' => 'umkm/v_index', 
        ];
        return view('v_template_back_end', $data);
    }
}
