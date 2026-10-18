<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\BaseConnection;

/**
 * Dasar semua controller API.
 * - Semua respons berformat JSON.
 * - Koneksi database dipilih lewat .env (API_DB_GROUP), jadi API bisa
 *   membaca MySQL ('default') atau PostgreSQL ('pgsql') tanpa ubah kode.
 */
class BaseApi extends BaseController
{
    use ResponseTrait;

    protected $format = 'json';

    /** @var BaseConnection */
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect(env('API_DB_GROUP', 'default'));
    }

    /** True bila API sedang membaca PostgreSQL. */
    protected function isPg(): bool
    {
        return stripos((string) $this->db->DBDriver, 'Postgre') !== false;
    }

    /**
     * Samakan tipe kolom saat membandingkan ID. MySQL otomatis menyamakan varchar dan
     * integer, PostgreSQL tidak (error "character varying = integer").
     */
    protected function txt(string $col): string
    {
        return $this->isPg() ? "CAST($col AS VARCHAR)" : $col;
    }

    /** Kondisi JOIN antar dua kolom ID yang aman untuk MySQL maupun PostgreSQL. */
    protected function joinOn(string $a, string $b): string
    {
        return $this->txt($a) . ' = ' . $this->txt($b);
    }

    /** Kondisi WHERE kolom ID = nilai angka dari URL, aman untuk kedua database. */
    protected function whereId($builder, string $col, int $value): void
    {
        $builder->where($this->txt($col) . ' = ' . $this->db->escape((string) $value), null, false);
    }

    /** Respons sukses standar. */
    protected function ok($data, array $meta = [])
    {
        $body = ['status' => 'success'];
        if ($meta) {
            $body['meta'] = $meta;
        }
        $body['data'] = $data;

        return $this->respond($body, 200);
    }

    /** Ambil limit & page dari query string dengan batas aman. */
    protected function paging(): array
    {
        $limit = (int) ($this->request->getGet('limit') ?? 100);
        $limit = max(1, min($limit, 1000));
        $page  = max(1, (int) ($this->request->getGet('page') ?? 1));

        return [$limit, $page, ($page - 1) * $limit];
    }

    /** "lat,lng" (format di kolom coordinat) -> [lat, lng] float, atau [null, null]. */
    protected function parseCoordinat(?string $coordinat): array
    {
        $p = array_map('trim', explode(',', (string) $coordinat));
        if (count($p) < 2 || !is_numeric($p[0]) || !is_numeric($p[1])) {
            return [null, null];
        }

        return [(float) $p[0], (float) $p[1]];
    }
}
