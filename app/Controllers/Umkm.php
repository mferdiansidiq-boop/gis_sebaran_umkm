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
            'judul'         => 'Input Umkm',
            'menu'          => 'umkm',
            'page'          => 'umkm/v_input',
            'web'           => $this->ModelSetting->Dataweb(),
            'provinsi'      => $this->ModelUmkm->allProvinsi(),
            'wilayah'       => $this->ModelWilayah->AllData(),
            'kategori_umkm' => $this->ModelKategoriumkm->AllData(), 
            'skala_usaha'   => $this->ModelSkalausaha->AllData(),
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
            'id_kategori_umkm' => [
                'label'  => 'Kategori UMKM',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'skala_usaha' => [
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
                // PERBAIKAN: Dinaikkan ke 5MB (5120) dan menghapus mime_in supaya semua ekstensi foto HP lolos
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
                'nama_umkm'        => $this->request->getPost('nama_umkm'),
                'id_kategori_umkm' => $this->request->getPost('id_kategori_umkm'),
                'skala_usaha'      => $this->request->getPost('skala_usaha'),    
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
            // Otomatis melempar error validasi bawaan ke halaman input agar terbaca filter pengintip error kita
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
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
        if ($this->validate([
            'nama_umkm' => [
                'label'  => 'Nama Umkm',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'id_kategori_umkm' => [
                'label'  => 'Kategori UMKM',
                'rules'  => 'required',
                'errors' => ['required' => '{field} Wajib Diisi !!']
            ],
            'skala_usaha' => [ 
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
                // PERBAIKAN: Disamakan kelonggarannya dengan sistem Insert di atas
                'rules'  => 'permit_empty|max_size[foto,5120]|is_image[foto]',
                'errors' => [
                    'max_size' => 'Ukuran {field} maksimal 5 MB !!',
                    'is_image' => 'File yang diupload harus berupa Gambar/Foto !!',
                ]
            ],
        ])) { 
            $umkm = $this->ModelUmkm->DetailData($id_umkm);
            $foto = $this->request->getFile('foto');

            if ($foto->getError() == 4) {
                $nama_file_foto = $umkm['foto'];
            } else {
                if (!empty($umkm['foto']) && file_exists('foto/' . $umkm['foto'])) {
                    unlink('foto/' . $umkm['foto']);
                }
                $nama_file_foto = $foto->getRandomName();
                $foto->move('foto', $nama_file_foto);
            }

            $data = [
                'id_umkm'          => $id_umkm,
                'nama_umkm'        => $this->request->getPost('nama_umkm'),
                'id_kategori_umkm' => $this->request->getPost('id_kategori_umkm'),
                'skala_usaha'      => $this->request->getPost('skala_usaha'), 
                'status'           => $this->request->getPost('status'),
                'coordinat'        => $this->request->getPost('coordinat'),
                'id_provinsi'      => $this->request->getPost('id_provinsi'),
                'id_kabupaten'     => $this->request->getPost('id_kabupaten'),
                'id_kecamatan'     => $this->request->getPost('id_kecamatan'),
                'alamat'           => $this->request->getPost('alamat'),
                'id_wilayah'       => $this->request->getPost('id_wilayah'),
                'foto'             => $nama_file_foto,
            ];
            
            $this->ModelUmkm->UpdateData($data);
            session()->setFlashdata('insert', 'Data Berhasil Diupdate!!');
            return redirect()->to(base_url('Umkm'));

        } else { 
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(base_url('Umkm/Edit/' . $id_umkm))->withInput();
        }
    }

    public function Delete($id_umkm)
    {
        $umkm = $this->ModelUmkm->DetailData($id_umkm);
        if (!empty($umkm['foto']) && file_exists('foto/' . $umkm['foto'])) {
            unlink('foto/' . $umkm['foto']);
        }
        $data = [
            'id_umkm' => $id_umkm,
        ];
        $this->ModelUmkm->DeleteData($data);
        session()->setFlashdata('delete', 'Data Berhasil Dihapus!!');
        return redirect()->to(base_url('Umkm'));
    }

    public function Detail($id_umkm)
    {
        $db = \Config\Database::connect();
        
        $umkm = $db->table('tbl_umkm')
            ->join('tbl_skala_usaha', 'tbl_skala_usaha.id_skala_usaha = tbl_umkm.skala_usaha', 'left')
            ->join('tbl_kategori_umkm', 'tbl_kategori_umkm.id_kategori_umkm = tbl_umkm.id_kategori_umkm', 'left')
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_umkm.id_kecamatan', 'left')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_umkm.id_kabupaten', 'left')
            ->join('tbl_wilayah', 'tbl_wilayah.id_wilayah = tbl_umkm.id_wilayah', 'left')
            ->where('tbl_umkm.id_umkm', $id_umkm)
            ->get()->getRowArray();

        $data = [
            'judul' => 'Detail Umkm',
            'menu'  => 'umkm',
            'page'  => 'umkm/v_detail',
            'web'   => $this->ModelSetting->Dataweb(),
            'umkm'  => $umkm, 
        ];
        return view('v_template_back_end', $data);
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