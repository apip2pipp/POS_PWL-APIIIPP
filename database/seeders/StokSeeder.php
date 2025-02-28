<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            //kategori 1 >> MBL (MOBIL)
            [
                'barang_id' =>1,
                'user_id'=>1,
                'stok_tanggal' => now(),
                'stok_jumlah'=>5,
            ],
            [
                'barang_id' =>2,
                'user_id'=>2,
                'stok_tanggal' => now(),
                'stok_jumlah'=>20,
            ],

            //kategori 2 >> CSI (CASING)
            [
                'barang_id' =>3,
                'user_id'=>1,
                'stok_tanggal' => now(),
                'stok_jumlah'=>30,
            ],
            [
                'barang_id' =>4,
                'user_id'=>2,
                'stok_tanggal' => now(),
                'stok_jumlah'=>30,
            ],

            //kategori 3 >> MIN (MINUMAN)
            [
                'barang_id' =>5,
                'user_id'=>1,
                'stok_tanggal' => now(),
                'stok_jumlah'=>60,
            ],
            [
                'barang_id' =>6,
                'user_id'=>2,
                'stok_tanggal' => now(),
                'stok_jumlah'=>60,
            ],

            //kategori 4 >> LAP (LAPTOP)
            [
                'barang_id' =>7,
                'user_id'=>1,
                'stok_tanggal' => now(),
                'stok_jumlah'=>20,
            ],
            [
                'barang_id' =>8,
                'user_id'=>2,
                'stok_tanggal' => now(),
                'stok_jumlah'=>20,
            ],
            
            //kategori 5 >> HAP (HANDPHONE)
            [
                'barang_id' =>9,
                'user_id'=>2,
                'stok_tanggal' => now(),
                'stok_jumlah'=>12,
            ],
            [
                'barang_id' =>10,
                'user_id'=>3,
                'stok_tanggal' => now(),
                'stok_jumlah'=>3,
            ],
        ];
        DB::table('t_stok')->insert($data);
    }
}
