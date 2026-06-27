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

    public function UpdateData($id_skala_usaha) 
    {
        $marker = $this->request->getFile('marker');
        $name_file = $marker->getRandomName();
        $data = [
            'id_skala_usaha'=> $id_skala_usaha,
            'marker' => $name_file,
            ];
            $marker->move('marker', $name_file);
            $this->ModelSkalausaha->UpdateData($data);
            session()->setFlashdata('update','Marker Berhasil Update!!');
            return redirect()->to('skala-usaha');
    }
}
