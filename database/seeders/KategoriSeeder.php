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
                'kategori_kode' => 'OPP',
                'kategori_nama' => 'OPPO',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'VIO',
                'kategori_nama' => 'VIVO',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'SMS',
                'kategori_nama' => 'SAMSUNG',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'APL',
                'kategori_nama' => 'APPLE',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'HWI',
                'kategori_nama' => 'HUWAWEI',
            ],
           
        ];
        DB::table('m_kategori')->insert($data);
    }
}
