<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            [
                'user_id' => 1,
                'pembeli' => 'malih',
                'penjualan_kode' => 'PJ001',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'MEGA',
                'penjualan_kode' => 'PJ002',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'kamim',
                'penjualan_kode' => 'PJ003',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'sowin',
                'penjualan_kode' => 'PJ004',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'rangkabumi',
                'penjualan_kode' => 'PJ005',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'mulyono',
                'penjualan_kode' => 'PJ006',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'bila',
                'penjualan_kode' => 'PJ007',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'towi',
                'penjualan_kode' => 'PJ008',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'vera',
                'penjualan_kode' => 'PJ009',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'JARWO',
                'penjualan_kode' => 'PJ010',
                'penjualan_tanggal' => now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
    ];
    DB::table('t_penjualan')->insert($data);
    }
}
