<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class KategoriController extends Controller
{
    public function index(){

    
    //  $data = [
    //         'kategori_kode' => 'HOD',   
    //         'kategori_nama' => 'HOODIE CHAMBRE',
    //         'created_at' => now()
    //     ];
    //     DB::table('m_kategori')-> insert($data);
    //     return 'Insert data kategori baru berhasil!';

        // $row = DB::table('m_kategori') -> where('kategori_kode', 'SNK') -> update(['kategori_nama' => 'Camilan']);
        // return 'Update data kategori berhasil. Jumlah data yang diperbarui: '.$row.' baris';
        
        // $row = DB::table('m_kategori') -> where('kategori_kode', 'HOD') -> delete();
        // return 'Delete data kategori berhasil. Jumlah data yang diperbarui: '.$row.' baris';

        $data = DB::table('m_kategori') -> get();
        return view('kategori', ['data' => $data]);
    }
}
