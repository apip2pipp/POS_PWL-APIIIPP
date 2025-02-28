<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            ['penjualan_id' => 1, 'barang_id' => 1, 'harga' => 15000000, 'jumlah' => 1,],
            ['penjualan_id' => 1, 'barang_id' => 2, 'harga' => 1000000, 'jumlah' => 1],
            ['penjualan_id' => 1, 'barang_id' => 3, 'harga' => 15000, 'jumlah' => 5],

            ['penjualan_id' => 2, 'barang_id' => 4, 'harga' => 65000, 'jumlah' => 9],
            ['penjualan_id' => 2, 'barang_id' => 5, 'harga' => 24000, 'jumlah' => 10],
            ['penjualan_id' => 2, 'barang_id' => 6, 'harga' => 17000, 'jumlah' => 5],

            ['penjualan_id' => 3, 'barang_id' => 7, 'harga' => 12000000, 'jumlah' => 3],
            ['penjualan_id' => 3, 'barang_id' => 8, 'harga' => 14000000, 'jumlah' => 1],
            ['penjualan_id' => 3, 'barang_id' => 9, 'harga' => 1500000, 'jumlah' => 7],

            ['penjualan_id' => 4, 'barang_id' => 10, 'harga' => 9500000, 'jumlah' => 10],
            ['penjualan_id' => 4, 'barang_id' => 9, 'harga' => 1500000, 'jumlah' => 3],
            ['penjualan_id' => 4, 'barang_id' => 8, 'harga' => 14000000, 'jumlah' => 4],

            ['penjualan_id' => 5, 'barang_id' => 7, 'harga' => 12000000, 'jumlah' => 2],
            ['penjualan_id' => 5, 'barang_id' => 6, 'harga' => 17000, 'jumlah' => 2],
            ['penjualan_id' => 5, 'barang_id' => 5, 'harga' => 24000, 'jumlah' => 2],

            ['penjualan_id' => 6, 'barang_id' => 4, 'harga' => 65000, 'jumlah' => 4],
            ['penjualan_id' => 6, 'barang_id' => 3, 'harga' => 15000, 'jumlah' => 4],
            ['penjualan_id' => 6, 'barang_id' => 2, 'harga' => 1000000, 'jumlah' => 4],

            ['penjualan_id' => 7, 'barang_id' => 1, 'harga' => 15000000, 'jumlah' => 2],
            ['penjualan_id' => 7, 'barang_id' => 10, 'harga' => 9500000, 'jumlah' => 3],
            ['penjualan_id' => 7, 'barang_id' => 9, 'harga' => 1500000, 'jumlah' => 3],

            ['penjualan_id' => 8, 'barang_id' => 8, 'harga' => 14000000, 'jumlah' => 10],
            ['penjualan_id' => 8, 'barang_id' => 7, 'harga' => 12000000, 'jumlah' => 3],
            ['penjualan_id' => 8, 'barang_id' => 6, 'harga' => 17000, 'jumlah' => 4],

            ['penjualan_id' => 9, 'barang_id' => 5, 'harga' => 24000, 'jumlah' => 1],
            ['penjualan_id' => 9, 'barang_id' => 4, 'harga' => 65000, 'jumlah' => 2],
            ['penjualan_id' => 9, 'barang_id' => 3, 'harga' => 15000, 'jumlah' => 2],

            ['penjualan_id' => 10, 'barang_id' => 2, 'harga' => 1000000, 'jumlah' => 1],
            ['penjualan_id' => 10, 'barang_id' => 1, 'harga' => 15000000, 'jumlah' => 3],
            ['penjualan_id' => 10, 'barang_id' => 10, 'harga' => 9500000, 'jumlah' => 4],
    ];
    DB::table('t_penjualan_detail')->insert($data);
    }
}
