<?php

namespace App\Controllers\Api;

class Umkm extends BaseApi
{
    /** Query dasar + join, dipakai bersama oleh index/show/geojson. */
    private function baseQuery()
    {
        return $this->db->table('tbl_umkm')
            ->select('tbl_umkm.*, tbl_skala_usaha.skala_usaha AS nama_skala, tbl_skala_usaha.marker,'
                . ' tbl_kategori_umkm.nama_kategori_umkm, tbl_provinsi.nama_provinsi,'
                . ' tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_wilayah.nama_wilayah')
            ->join('tbl_skala_usaha', $this->joinOn('tbl_skala_usaha.id_skala_usaha', 'tbl_umkm.skala_usaha'), 'left', false)
            ->join('tbl_kategori_umkm', $this->joinOn('tbl_kategori_umkm.id_kategori_umkm', 'tbl_umkm.id_kategori_umkm'), 'left', false)
            ->join('tbl_provinsi', $this->joinOn('tbl_provinsi.id_provinsi', 'tbl_umkm.id_provinsi'), 'left', false)
            ->join('tbl_kabupaten', $this->joinOn('tbl_kabupaten.id_kabupaten', 'tbl_umkm.id_kabupaten'), 'left', false)
            ->join('tbl_kecamatan', $this->joinOn('tbl_kecamatan.id_kecamatan', 'tbl_umkm.id_kecamatan'), 'left', false)
            ->join('tbl_wilayah', $this->joinOn('tbl_wilayah.id_wilayah', 'tbl_umkm.id_wilayah'), 'left', false);
    }

    /** Filter opsional: ?kategori= &skala= &kecamatan= &kabupaten= &wilayah= &q= */
    private function applyFilters($b): void
    {
        $map = [
            'kategori'  => 'tbl_umkm.id_kategori_umkm',
            'skala'     => 'tbl_umkm.skala_usaha',
            'kecamatan' => 'tbl_umkm.id_kecamatan',
            'kabupaten' => 'tbl_umkm.id_kabupaten',
            'wilayah'   => 'tbl_umkm.id_wilayah',
        ];
        foreach ($map as $param => $column) {
            $v = $this->request->getGet($param);
            if ($v !== null && $v !== '' && ctype_digit((string) $v)) {
                $this->whereId($b, $column, (int) $v);
            }
        }

        $q = trim((string) $this->request->getGet('q'));
        if ($q !== '') {
            $b->groupStart()
                ->like('tbl_umkm.nama_umkm', $q, 'both', null, true)
                ->orLike('tbl_umkm.alamat', $q, 'both', null, true)
                ->groupEnd();
        }
    }

    /** Bentuk data datar (flat) supaya mudah dibaca Power BI / datawarehouse. */
    private function bentuk(array $r): array
    {
        [$lat, $lng] = $this->parseCoordinat($r['coordinat'] ?? null);

        return [
            'id_umkm'          => (int) $r['id_umkm'],
            'nama_umkm'        => $r['nama_umkm'],
            'id_kategori_umkm' => $r['id_kategori_umkm'] !== null ? (int) $r['id_kategori_umkm'] : null,
            'kategori'         => $r['nama_kategori_umkm'] ?? null,
            'id_skala_usaha'   => $r['skala_usaha'] !== null ? (int) $r['skala_usaha'] : null,
            'skala_usaha'      => $r['nama_skala'] ?? null,
            'status'           => $r['status'],
            'alamat'           => $r['alamat'],
            'provinsi'         => $r['nama_provinsi'] ?? null,
            'kabupaten'        => $r['nama_kabupaten'] ?? null,
            'kecamatan'        => $r['nama_kecamatan'] ?? null,
            'wilayah'          => $r['nama_wilayah'] ?? null,
            'latitude'         => $lat,
            'longitude'        => $lng,
            'foto_url'         => !empty($r['foto']) ? base_url('foto/' . rawurlencode($r['foto'])) : null,
            'marker_url'       => !empty($r['marker']) ? base_url('marker/' . rawurlencode($r['marker'])) : null,
        ];
    }

    // GET /api/v1/umkm
    public function index()
    {
        [$limit, $page, $offset] = $this->paging();

        $b = $this->baseQuery();
        $this->applyFilters($b);

        $total = $b->countAllResults(false);
        $rows  = $b->orderBy('tbl_umkm.id_umkm', 'ASC')->limit($limit, $offset)->get()->getResultArray();

        return $this->ok(array_map([$this, 'bentuk'], $rows), [
            'total' => $total,
            'page'  => $page,
            'limit' => $limit,
        ]);
    }

    // GET /api/v1/umkm/{id}
    public function show($id = null)
    {
        $b = $this->baseQuery();
        $this->whereId($b, 'tbl_umkm.id_umkm', (int) $id);
        $row = $b->get()->getRowArray();
        if (!$row) {
            return $this->failNotFound('UMKM dengan id ' . (int) $id . ' tidak ditemukan.');
        }

        return $this->ok($this->bentuk($row));
    }

    // GET /api/v1/umkm/geojson  (FeatureCollection titik; bisa langsung dipakai Leaflet/QGIS)
    public function geojson()
    {
        $b = $this->baseQuery();
        $this->applyFilters($b);
        $rows = $b->orderBy('tbl_umkm.id_umkm', 'ASC')->get()->getResultArray();

        $features = [];
        foreach ($rows as $r) {
            $f = $this->bentuk($r);
            if ($f['latitude'] === null) {
                continue; // lewati data tanpa koordinat valid
            }
            $lat = $f['latitude'];
            $lng = $f['longitude'];
            unset($f['latitude'], $f['longitude']);

            $features[] = [
                'type'       => 'Feature',
                'geometry'   => ['type' => 'Point', 'coordinates' => [$lng, $lat]], // GeoJSON = [lng, lat]
                'properties' => $f,
            ];
        }

        return $this->response
            ->setJSON(['type' => 'FeatureCollection', 'features' => $features]);
    }
}
