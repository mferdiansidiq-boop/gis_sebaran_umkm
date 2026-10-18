<?php

namespace App\Controllers\Api;

/** Data referensi (kategori, skala usaha) dan statistik ringkas untuk dashboard. */
class Referensi extends BaseApi
{
    // GET /api/v1/kategori
    public function kategori()
    {
        $rows = $this->db->table('tbl_kategori_umkm')->orderBy('id_kategori_umkm', 'ASC')->get()->getResultArray();

        return $this->ok($rows, ['total' => count($rows)]);
    }

    // GET /api/v1/skala-usaha
    public function skala()
    {
        $rows = $this->db->table('tbl_skala_usaha')->orderBy('id_skala_usaha', 'ASC')->get()->getResultArray();
        foreach ($rows as &$r) {
            $r['marker_url'] = !empty($r['marker']) ? base_url('marker/' . rawurlencode($r['marker'])) : null;
        }

        return $this->ok($rows, ['total' => count($rows)]);
    }

    // GET /api/v1/statistik  -> jumlah UMKM per kategori, skala usaha, dan wilayah
    public function statistik()
    {
        $perKategori = $this->db->table('tbl_kategori_umkm k')
            ->select('k.id_kategori_umkm, k.nama_kategori_umkm AS kategori, COUNT(u.id_umkm) AS jumlah')
            ->join('tbl_umkm u', $this->joinOn('u.id_kategori_umkm', 'k.id_kategori_umkm'), 'left', false)
            ->groupBy('k.id_kategori_umkm, k.nama_kategori_umkm')
            ->orderBy('k.id_kategori_umkm', 'ASC')
            ->get()->getResultArray();

        $perSkala = $this->db->table('tbl_skala_usaha s')
            ->select('s.id_skala_usaha, s.skala_usaha AS skala, COUNT(u.id_umkm) AS jumlah')
            ->join('tbl_umkm u', $this->joinOn('u.skala_usaha', 's.id_skala_usaha'), 'left', false)
            ->groupBy('s.id_skala_usaha, s.skala_usaha')
            ->orderBy('s.id_skala_usaha', 'ASC')
            ->get()->getResultArray();

        $perWilayah = $this->db->table('tbl_wilayah w')
            ->select('w.id_wilayah, w.nama_wilayah AS wilayah, COUNT(u.id_umkm) AS jumlah')
            ->join('tbl_umkm u', $this->joinOn('u.id_wilayah', 'w.id_wilayah'), 'left', false)
            ->groupBy('w.id_wilayah, w.nama_wilayah')
            ->orderBy('w.id_wilayah', 'ASC')
            ->get()->getResultArray();

        $cast = static fn (array $rows) => array_map(static function ($r) {
            $r['jumlah'] = (int) $r['jumlah'];

            return $r;
        }, $rows);

        return $this->ok([
            'total_umkm'   => (int) $this->db->table('tbl_umkm')->countAllResults(),
            'per_kategori' => $cast($perKategori),
            'per_skala'    => $cast($perSkala),
            'per_wilayah'  => $cast($perWilayah),
        ]);
    }
}
