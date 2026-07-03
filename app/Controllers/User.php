<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;

class User extends BaseController
{
    protected $ModelUser;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
    }
    public function index()
    {
        $data = [
            'judul' => 'User',
            'menu' => 'user',
            'page' => 'User/v_index',
            'user' => $this->ModelUser->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

     public function Input()
    {
        $data = [
            'judul'         => 'Input User',
            'menu'          => 'user',
            'page'          => 'user/v_input',
        ];
        return view('v_template_back_end', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'nama_user' => [
                'label'  => 'Nama User',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'email' => [
                'label'  => 'E-Mail',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!',
                    'valid_email' => '{field} tidak valid !!'
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'foto' => [
                'label'  => 'Foto User',
                'rules'  => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload !!',
                    'max_size' => 'Ukuran {field} max 1024 kb !!',
                    'mime_in'  => 'Format {field} Harus JPG, JPEG, PNG !!',
                ]
            ],
        ])) { 
            $foto = $this->request->getFile('foto');
            $nama_file_foto = $foto->getRandomName();

            $data = [
                'nama_user'        => $this->request->getPost('nama_user'),
                'email' => $this->request->getPost('email'),
                'password' => sha1($this->request->getPost('password')),
                'foto'             => $nama_file_foto,
            ];
            
            $foto->move('foto', $nama_file_foto);

            $this->ModelUser->InsertData($data);
            session()->setFlashdata('insert', 'Data Berhasil Ditambahkan!!');
            return redirect()->to(base_url('User'));

        } else { 
            // Menggunakan cara bawaan CI4 yang otomatis aman dari file serialization
            return redirect()->to(base_url('Umkm/Input'))->withInput(); 
        }
    }
}
