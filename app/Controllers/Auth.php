<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUser;

class Auth extends BaseController
{
    protected $ModelUser;

    public function __construct()
    {
        $this->ModelUser = new ModelUser();
    }

    public function Login()
    {
        // Jika user sudah login, langsung lempar ke halaman utama (User index dengan huruf kecil)
        if (session()->get('log_in') == true) {
            return redirect()->to(base_url('admin'));
        }

        $data = [
            'judul' => 'Login - Sistem UMKM',
        ];
        return view('v_login', $data);
    }

    public function CekLogin()
    {
        if ($this->validate([
            'email' => [
                'label'  => 'E-Mail',
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => '{field} Wajib Diisi !!',
                    'valid_email' => 'Format {field} Salah !!'
                ]
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
        ])) {
            // Validasi sukses, lanjut cek ke database
            $email    = $this->request->getPost('email');
            $password = sha1($this->request->getPost('password')); 

            $cek = $this->ModelUser->LoginUser($email, $password);

            if ($cek) {
                // Jika data cocok, buat data session login
                session()->set([
                    'log_in'    => true,
                    'id_user'   => $cek['id_user'],
                    'nama_user' => $cek['nama_user'],
                    'email'     => $cek['email'],
                    'foto'      => $cek['foto'],
                ]);
                // PERBAIKAN: Gunakan 'user' huruf kecil agar selaras dengan Route manual & Group
                return redirect()->to(base_url('admin')); 
            } else {
                // Jika data tidak cocok
                session()->setFlashdata('pesan', 'E-Mail atau Password Salah!');
                // PERBAIKAN: Redirect ke 'login' huruf kecil agar lolos dari blokir AutoRouter
                return redirect()->to(base_url('login'))->withInput();
            }

        } else {
            // Jika validasi form gagal
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            // PERBAIKAN: Redirect ke 'login' huruf kecil
            return redirect()->to(base_url('login'))->withInput();
        }
    }

    public function Logout()
{
    // Menghapus seluruh session login admin/user
    session()->destroy();
    
    // MENGARAHKAN KEMBALI KE HALAMAN UTAMA (PUBLIC)
    return redirect()->to(base_url('/')); 
}
}