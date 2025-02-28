<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'MBL',
                'kategori_nama' => 'MOBIL',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'CSI',
                'kategori_nama' => 'CASING',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'MIN',
                'kategori_nama' => 'MINUMAN',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'LAP',
                'kategori_nama' => 'LAPTOP',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'HAP',
                'kategori_nama' => 'HANDPHONE',
            ],
           
        ];
        DB::table('m_kategori')->insert($data);
    }
}
