<?php

namespace App\Controllers;

use App\Models\ModelSetting;

class Admin extends BaseController
{
protected $ModelSetting;

public function __construct() 
{
   $this->ModelSetting = new ModelSetting();
}

    public function index()
    {
         helper('form');

        $data = [
            'judul' => 'Dashboard',
            'page' => 'v_dashboard',
        ];
        return view('v_template_back_end', $data);
    }

    public function Setting()
    {
        helper('form');
        session();


        $data = [
            'judul' => 'Setting',
            'page' => 'v_setting',
            'web' => $this->ModelSetting->Dataweb(),
        ];
        return view('v_template_back_end', $data);
    }

    public function updatesetting()
{
    $data = [
        'id' => 1,
        'nama_web' => $this->request->getPost('nama_web'),
        'coordinat_wilayah' => $this->request->getPost('coordinat_wilayah'),
        'zoom_view' => $this->request->getPost('zoom_view'),
    ];

    $this->ModelSetting->UpdateData($data);
    session()->setFlashdata('pesan', 'Settingan Web Telah Diupdate !!!');
    return redirect()->to(base_url('/admin/setting'));
}

}