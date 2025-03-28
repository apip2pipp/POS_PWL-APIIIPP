<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar kategori barang',
                'list' => ['Home', 'Kategori']
            ],
            'kategori' => KategoriModel::all(),
            'page' => (object) [
                'title' => 'Daftar kategori barang yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'kategori'
        ]);
    }


    public function list(Request $req) 
    {
        $kategori = KategoriModel::select( 'kategori_id', 'kategori_kode', 'kategori_nama');

        if ($req->kategori_id) {
            $kategori->where('kategori_id', $req->kategori_id);
        }

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $detailUrl = route('kategori.show', ['id' => $kategori->kategori_id]);
                $editUrl = route('kategori.edit-ajax', ['id' => $kategori->kategori_id]);
                $deleteUrl = route('kategori.delete-ajax', ['id' => $kategori->kategori_id]);
                
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteUrl}')" class="btn btn-danger btn-sm">Hapus</button>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // public function create()
    // {
    //     return view('kategori.create', [
    //         'breadcrumb' => (object) [
    //             'title' => 'Tambah Kategori Barang',
    //             'list' => ['Home', 'Kategori', 'Tambah']
    //         ],
    //         'page' => (object) [
    //             'title' => 'Tambah kategori barang baru'
    //         ],
    //         'kategori' => KategoriModel::all(),
    //         'activeMenu' => 'kategori'
    //     ]);
    // }
}
