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
        // 1. Ambil data lama terlebih dahulu untuk mengetahui nama file marker yang sekarang
        $skala_usaha_lama = $this->ModelSkalausaha->DetailData($id_skala_usaha); // Pastikan fungsi DetailData($id) ada di Modelmu

        $marker = $this->request->getFile('marker');

        // 2. Cek apakah ada file baru yang diupload (Error 4 artinya tidak ada file diupload)
        if ($marker->getError() == 4) {
            // Jika tidak pilih file baru, gunakan nama file yang lama
            $name_file = $skala_usaha_lama['marker'];
        } else {
            // Jika ada file baru, hapus file lama dari folder 'marker' agar tidak menumpuk
            if (!empty($skala_usaha_lama['marker']) && file_exists('marker/' . $skala_usaha_lama['marker'])) {
                unlink('marker/' . $skala_usaha_lama['marker']);
            }

            // Generate nama random baru dan pindahkan filenya
            $name_file = $marker->getRandomName();
            $marker->move('marker', $name_file);
        }

        // 3. Eksekusi update ke database
        $data = [
            'id_skala_usaha' => $id_skala_usaha,
            'marker'         => $name_file,
        ];

        $this->ModelSkalausaha->UpdateData($data);
        session()->setFlashdata('update', 'Marker Berhasil Update!!');
        return redirect()->to(base_url('skala-usaha')); // Gunakan base_url agar redirect lebih aman
    }
}
