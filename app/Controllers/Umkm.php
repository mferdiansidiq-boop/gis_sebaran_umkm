<?php

namespace App\Controllers;

use App\Models\ModelSkalausaha;
use App\Controllers\BaseController;
use App\Models\ModelUmkm;
use App\Models\ModelWilayah;
use App\Models\ModelSetting;
use App\Models\ModelKategoriumkm;

use CodeIgniter\HTTP\ResponseInterface;

class UMKM extends BaseController
{
    protected $ModelWilayah;
    protected $ModelSetting;
    protected $ModelUmkm;
    protected $ModelSkalausaha;
    protected $ModelKategoriumkm;

    public function __construct() 
    {
        $this->ModelWilayah = new ModelWilayah();
        $this->ModelSetting = new ModelSetting();
        $this->ModelUmkm = new ModelUmkm();
        $this->ModelSkalausaha = new ModelSkalausaha();
        $this->ModelKategoriumkm = new ModelKategoriumkm();
        
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
        if ($this->validate([
            'nama_umkm' => [
                'label'  => 'Nama Umkm',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_skala_usaha' => [
                'label'  => 'Skala Usaha',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'status' => [
                'label'  => 'status',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'coordinat' => [
                'label'  => 'Coordinat',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_provinsi' => [
                'label'  => 'Provinsi',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kabupaten' => [
                'label'  => 'Kabupaten',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kecamatan' => [
                'label'  => 'Kecamatan',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'alamat' => [
                'label'  => 'Alamat',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_wilayah' => [
                'label'  => 'Wilayah Administrasi',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'foto' => [
                'label'  => 'Foto Umkm',
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
                'id_umkm'          => $id_umkm,
                'nama_umkm'        => $this->request->getPost('nama_umkm'),
                'id_kategori_umkm' => $this->request->getPost('id_kategori_umkm'),
                'skala_usaha'      => $this->request->getPost('id_skala_usaha'),    
                'status'           => $this->request->getPost('status'),
                'coordinat'        => $this->request->getPost('coordinat'),
                'id_provinsi'      => $this->request->getPost('id_provinsi'),
                'id_kabupaten'     => $this->request->getPost('id_kabupaten'),
                'id_kecamatan'     => $this->request->getPost('id_kecamatan'),
                'alamat'           => $this->request->getPost('alamat'),
                'id_wilayah'       => $this->request->getPost('id_wilayah'),
                'foto'             => $nama_file_foto,
            ];
            
            $foto->move('foto', $nama_file_foto);

            $this->ModelUmkm->InsertData($data);
            session()->setFlashdata('insert', 'Data Berhasil Ditambahkan!!');
            return redirect()->to(base_url('Umkm'));

        } else { 
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to(base_url('Umkm/Input'))->withInput();
        }
    }

    public function Edit($id_umkm)
    {
        $data = [
            'judul'         => 'Edit Umkm',
            'menu'          => 'umkm',
            'page'          => 'umkm/v_edit',
            'web'           => $this->ModelSetting->Dataweb(),
            'provinsi'      => $this->ModelUmkm->allProvinsi(),
            'wilayah'       => $this->ModelWilayah->AllData(),
            'skala_usaha'   => $this->ModelSkalausaha->AllData(), 
            'kategori_umkm' => $this->ModelKategoriumkm->AllData(), 
            'umkm'          => $this->ModelUmkm->DetailData($id_umkm),
        ];

        return view('v_template_back_end', $data);
    }

    public function UpdateData($id_umkm)
    {
        // 1. JALANKAN VALIDASI (Menggunakan permit_empty agar foto TIDAK WAJIB saat edit)
        if ($this->validate([
            'nama_umkm' => [
                'label'  => 'Nama Umkm',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_skala_usaha' => [
                'label'  => 'Skala Usaha',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'status' => [
                'label'  => 'status',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'coordinat' => [
                'label'  => 'Coordinat',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_provinsi' => [
                'label'  => 'Provinsi',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kabupaten' => [
                'label'  => 'Kabupaten',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kecamatan' => [
                'label'  => 'Kecamatan',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'alamat' => [
                'label'  => 'Alamat',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_wilayah' => [
                'label'  => 'Wilayah Administrasi',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'foto' => [
                'label'  => 'Foto Umkm',
                'rules'  => 'permit_empty|max_size[foto,1024]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran {field} max 1024 kb !!',
                    'mime_in'  => 'Format {field} Harus JPG, JPEG, PNG !!',
                ]
            ],
        ])) { 
            $umkm = $this->ModelUmkm->DetailData($id_umkm);
            $foto = $this->request->getFile('foto');

            // Cek kondisi file upload
            if ($foto->getError() == 4) {
                $nama_file_foto = $umkm['foto'];
            } else {
                if (!empty($umkm['foto']) && file_exists('foto/' . $umkm['foto'])) {
                    unlink('foto/' . $umkm['foto']);
                }
                $nama_file_foto = $foto->getRandomName();
                $foto->move('foto', $nama_file_foto);
            }

            // SUSUN VARIABEL DATA (id_sekolah dibuang, dicocokkan ke database terbaru)
            $data = [
                'id_umkm'          => $id_umkm,
                'nama_umkm'        => $this->request->getPost('nama_umkm'),
                'id_kategori_umkm' => $this->request->getPost('id_kategori_umkm'),
                'skala_usaha'   => $this->request->getPost('id_skala_usaha'),
                'status'           => $this->request->getPost('status'),
                'coordinat'        => $this->request->getPost('coordinat'),
                'id_provinsi'      => $this->request->getPost('id_provinsi'),
                'id_kabupaten'     => $this->request->getPost('id_kabupaten'),
                'id_kecamatan'     => $this->request->getPost('id_kecamatan'),
                'alamat'           => $this->request->getPost('alamat'),
                'id_wilayah'       => $this->request->getPost('id_wilayah'),
                'foto'             => $nama_file_foto,
            ];
            
            // Eksekusi update data ke model
            $this->ModelUmkm->UpdateData($data);
            session()->setFlashdata('insert', 'Data Berhasil Diupdate!!');
            return redirect()->to(base_url('Umkm'));

        } else { 
            // JIKA VALIDASI GAGAL -> Kirim session 'validation' agar dibaca oleh View Anda
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to(base_url('Umkm/Edit/' . $id_umkm))->withInput();
        }
    }

    public function Kabupaten()
    {
        $id_provinsi = $this->request->getPost('id_provinsi');
        $kab = $this->ModelUmkm->allKabupaten($id_provinsi);
        echo '<option value="">--Pilih Kabupaten--</option>';
        foreach ($kab as $key => $value) {
            echo '<option value="' . $value['id_kabupaten'] . '">' . $value['nama_kabupaten'] . '</option>';
        }
    }

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