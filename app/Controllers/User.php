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
            'menu'  => 'user',
            'page'  => 'user/v_index',
            'user'  => $this->ModelUser->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

    public function Input()
    {
        $data = [
            'judul' => 'Input User',
            'menu'  => 'user',
            'page'  => 'user/v_input',
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
                    'required'    => '{field} Wajib Diisi !!',
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
                // PERBAIKAN: Naik ke 5MB & bebas format gambar HP lewat rule is_image
                'rules'  => 'uploaded[foto]|max_size[foto,5120]|is_image[foto]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload !!',
                    'max_size' => 'Ukuran {field} maksimal 5 MB !!',
                    'is_image' => 'File yang diupload harus berupa Gambar/Foto !!',
                ]
            ],
        ])) { 
            $foto = $this->request->getFile('foto');
            $nama_file_foto = $foto->getRandomName();

            $data = [
                'nama_user' => $this->request->getPost('nama_user'),
                'email'     => $this->request->getPost('email'),
                'password'  => sha1($this->request->getPost('password')),
                'foto'      => $nama_file_foto,
            ];
            
            $foto->move('foto', $nama_file_foto);

            // PERBAIKAN: Menggunakan fungsi simpan baru (InsertData)
            $this->ModelUser->InsertData($data);
            session()->setFlashdata('insert', 'Data Berhasil Ditambahkan!!');
            return redirect()->to(base_url('User'));

        } else { 
            // PERBAIKAN: Redirect diarahkan kembali ke halaman input User
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('User/Input'))->withInput(); 
        }
    }

    public function Edit($id_user)
    {
        $data = [
            'judul' => 'Edit User',
            'menu'  => 'user',
            'page'  => 'user/v_edit',
            'user'  => $this->ModelUser->DetailData($id_user),
        ];
        return view('v_template_back_end', $data);
    }

    public function UpdateData($id_user)
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
                    'required'    => '{field} Wajib Diisi !!',
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
                // PERBAIKAN: Menggunakan permit_empty agar tidak error saat user hanya ganti nama/email saja
                'rules'  => 'permit_empty|max_size[foto,5120]|is_image[foto]',
                'errors' => [
                    'max_size' => 'Ukuran {field} maksimal 5 MB !!',
                    'is_image' => 'File yang diupload harus berupa Gambar/Foto !!',
                ]
            ],
        ])) { 
            $foto = $this->request->getFile('foto');
            $user = $this->ModelUser->DetailData($id_user);

            // Logika penggantian berkas gambar lama
            if ($foto->getError() == 4) {
                $nama_file_foto = $user['foto'];
            } else {
                // Menghapus berkas foto lama di folder jika ada berkas baru yang masuk
                if (!empty($user['foto']) && file_exists('foto/' . $user['foto'])) {
                    unlink('foto/' . $user['foto']);
                }
                $nama_file_foto = $foto->getRandomName();
                $foto->move('foto', $nama_file_foto);
            }

            $data = [
                'id_user'   => $id_user,
                'nama_user' => $this->request->getPost('nama_user'),
                'email'     => $this->request->getPost('email'),
                'password'  => sha1($this->request->getPost('password')),
                'foto'      => $nama_file_foto,
            ];
            
            // PERBAIKAN: Menggunakan fungsi perbarui data (UpdateData)
            $this->ModelUser->UpdateData($data);
            session()->setFlashdata('update', 'Data Berhasil Diupdate!!');
            return redirect()->to(base_url('User'));

        } else { 
            // PERBAIKAN: Redirect dilempar balik menuju halaman edit User terkait
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('User/Edit/' . $id_user))->withInput(); 
        }
    }

     public function Delete($id_user)
    {
        $user = $this->ModelUser->DetailData($id_user);
        if (!empty($user['foto']) && file_exists('foto/' . $user['foto'])) {
            unlink('foto/' . $user['foto']);
        }
        $data = [
            'id_user' => $id_user,
        ];
        $this->ModelUser->DeleteData($data);
        session()->setFlashdata('delete', 'Data Berhasil Dihapus!!');
        return redirect()->to(base_url('User'));
    }
}