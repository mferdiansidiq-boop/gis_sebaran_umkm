<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Dashboard',
            'page' => 'v_dashboard',
        ];
        return view('v_template_back_end', $data);
    }
}
