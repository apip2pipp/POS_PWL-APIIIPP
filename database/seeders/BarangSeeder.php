<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                //KATEGORI 1 >> MBL (MOBIL)
                'kategori_id' => 1,
                'barang_kode' => 'MBL001',
                'barang_nama' => 'PORSCHE',
                'harga_beli' => 10000000,
                'harga_jual' => 15000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'MBL002',
                'barang_nama' => 'AVANZA',
                'harga_beli' => 7000000,
                'harga_jual' => 1000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

                
            [
                //KATEGORI 2 >> CSI (CASING)
                'kategori_id' => 2,
                'barang_kode' => 'CSI001',
                'barang_nama' => 'SOFT CASE',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                
                'kategori_id' => 2,
                'barang_kode' => 'CSI002',
                'barang_nama' => 'HARD CASE',
                'harga_beli' => 60000,
                'harga_jual' => 65000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //KATEGORI 3 >> MIN (MINUMAN)
                'kategori_id' => 3,
                'barang_kode' => 'MIN001',
                'barang_nama' => 'BUTTERSCHOT COFFE',
                'harga_beli' => 10000,
                'harga_jual' => 24000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                
                'kategori_id' => 3,
                'barang_kode' => 'MIN002',
                'barang_nama' => 'MATCHA LATTE',
                'harga_beli' => 10000,
                'harga_jual' => 17000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //KATEGORI 4 >> LAP (LAPTOP)
                'kategori_id' => 4,
                'barang_kode' => 'LAP001',
                'barang_nama' => 'LENOVO IDEAPED GEMING',
                'harga_beli' => 10000000,
                'harga_jual' => 12000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                
                'kategori_id' => 4,
                'barang_kode' => 'LAP002',
                'barang_nama' => 'ASUS TUF',
                'harga_beli' => 12000000,
                'harga_jual' => 14000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                //KATEGORI 5 >> HAP (HANDPHOE)
                'kategori_id' => 5,
                'barang_kode' => 'HAP001',
                'barang_nama' => 'OPPO F9',
                'harga_beli' => 1000000,
                'harga_jual' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                
                'kategori_id' => 5,
                'barang_kode' => 'HAP002',
                'barang_nama' => 'IPHONE 13 PRO MAX',
                'harga_beli' => 8000000,
                'harga_jual' => 9500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ];
        DB::table('m_barang')->insert($data);
    }
}
