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
            'menu'  => 'umkm',
            'page'  => 'umkm/v_index', 
            'umkm'  => $this->ModelUmkm->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

    public function Input()
    {
        $data = [
            'judul'    => 'Input Umkm',
            'menu'     => 'umkm',
            'page'     => 'umkm/v_input',
            'web'      => $this->ModelSetting->Dataweb(),
            'provinsi' => $this->ModelUmkm->allProvinsi(),
            'wilayah'  => $this->ModelWilayah->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

public function InsertData()
    {
        // 1. LAKUKAN VALIDASI TERLEBIH DAHULU (Tanpa mengambil getFile dulu)
        if ($this->validate([
            'nama_umkm' => [
                'label'  => 'Nama Umkm',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'skala_usaha' => [
                'label'  => 'Skala Usaha',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'status' => [
                'label'  => 'status',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'coordinat' => [
                'label'  => 'Coordinat',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'id_provinsi' => [
                'label'  => 'Provinsi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'id_kabupaten' => [
                'label'  => 'Kabupaten',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'id_kecamatan' => [
                'label'  => 'Kecamatan',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'alamat' => [
                'label'  => 'Alamat',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'id_wilayah' => [
                'label'  => 'Wilayah Administrasi',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!'
                ]
            ],
            'foto' => [
                'label'  => 'Foto Umkm',
                // Aturan validasi file yang benar di CodeIgniter 4:
                'rules'  => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => '{field} Wajib Diupload !!',
                    'max_size' => 'Ukuran {field} max 1024 kb !!',
                    'mime_in'  => 'Format {field} Harus JPG, JPEG, PNG !!',
                ]
            ],
        ])) { 
            // JIKA VALIDASI BERHASIL -> BARU AMBIL DAN PINDAHKAN FILE DI SINI
            $foto = $this->request->getFile('foto');
            $nama_file_foto = $foto->getRandomName();

            $data = [
                'nama_umkm'    => $this->request->getPost('nama_umkm'),
                'skala_usaha'  => $this->request->getPost('skala_usaha'),
                'status'       => $this->request->getPost('status'),
                'coordinat'    => $this->request->getPost('coordinat'),
                'id_provinsi'  => $this->request->getPost('id_provinsi'),
                'id_kabupaten' => $this->request->getPost('id_kabupaten'),
                'id_kecamatan' => $this->request->getPost('id_kecamatan'),
                'alamat'       => $this->request->getPost('alamat'),
                'id_wilayah'   => $this->request->getPost('id_wilayah'),
                'foto'         => $nama_file_foto,
            ];
            
            $foto->move('foto', $nama_file_foto);

            $this->ModelUmkm->InsertData($data);
            session()->setFlashdata('insert', 'Data Berhasil Ditambahkan!!');
            return redirect()->to('Umkm');

        } else { 
            // JIKA VALIDASI GAGAL
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to('Umkm/Input')->withInput();
        }
    }

    //kabupaten
    public function Kabupaten()
    {
        $id_provinsi = $this->request->getPost('id_provinsi');
        $kab = $this->ModelUmkm->allKabupaten($id_provinsi);
        echo '<option value="">--Pilih Kabupaten--</option>';
        foreach ($kab as $key => $value) {
            echo '<option value="' . $value['id_kabupaten'] . '">' . $value['nama_kabupaten'] . '</option>';
        }
    }

    //kecamatan
    public function Kecamatan()
    {
        $id_kabupaten = $this->request->getPost('id_kabupaten');
        $kec = $this->ModelUmkm->allKecamatan($id_kabupaten);
        echo '<option value="">--Pilih Kecamatan--</option>';
        foreach ($kec as $key => $value) {
            echo '<option value="' . $value['id_kecamatan'] . '">' . $value['nama_kecamatan'] . '</option>';
        }
    }
}