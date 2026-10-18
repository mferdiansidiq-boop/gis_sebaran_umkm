<?php

namespace App\Controllers\Api;

class Wilayah extends BaseApi
{
    private function query()
    {
        // jumlah UMKM per wilayah dihitung lewat subquery supaya aman di MySQL maupun PostgreSQL
        return $this->db->table('tbl_wilayah')
            ->select('tbl_wilayah.*, (SELECT COUNT(*) FROM tbl_umkm WHERE '
                . $this->joinOn('tbl_umkm.id_wilayah', 'tbl_wilayah.id_wilayah') . ') AS jumlah_umkm', false);
    }

    private function bentuk(array $r, bool $withGeo): array
    {
        $out = [
            'id_wilayah'   => (int) $r['id_wilayah'],
            'nama_wilayah' => $r['nama_wilayah'],
            'warna'        => $r['warna'],
            'jumlah_umkm'  => (int) $r['jumlah_umkm'],
        ];
        if ($withGeo) {
            // kolom geojson disimpan sebagai teks; dikirim sebagai objek JSON
            $out['geojson'] = json_decode((string) $r['geojson']);
        }

        return $out;
    }

    // GET /api/v1/wilayah?geojson=0  (geojson=0 untuk menyembunyikan geometri agar ringan)
    public function index()
    {
        $withGeo = $this->request->getGet('geojson') !== '0';
        $rows    = $this->query()->orderBy('tbl_wilayah.id_wilayah', 'ASC')->get()->getResultArray();

        return $this->ok(array_map(fn ($r) => $this->bentuk($r, $withGeo), $rows), ['total' => count($rows)]);
    }

    // GET /api/v1/wilayah/{id}
    public function show($id = null)
    {
        $b = $this->query();
        $this->whereId($b, 'tbl_wilayah.id_wilayah', (int) $id);
        $row = $b->get()->getRowArray();
        if (!$row) {
            return $this->failNotFound('Wilayah dengan id ' . (int) $id . ' tidak ditemukan.');
        }

        return $this->ok($this->bentuk($row, true));
    }
}
