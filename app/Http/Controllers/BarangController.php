<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar  barang',
                'list' => ['Home', 'barang']
            ],
            'barang' => BarangModel::all(),
            'page' => (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'barang'
        ]);
    }

    public function list(Request $req) 
    {
        $barang = BarangModel::select( 'barang_id', 'barang_kode','barang_nama', 'harga_beli', 'harga_jual');

        if ($req->barang_id) {
            $barang->where('barang_id', $req->barang_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $detailUrl = route('barang.show', ['id' => $barang->barang_id]);
                $editUrl = route('barang.edit-ajax', ['id' => $barang->barang_id]);
                $deleteUrl = route('barang.delete-ajax', ['id' => $barang->barang_id]);
                
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteUrl}')" class="btn btn-danger btn-sm">Hapus</button>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(){
        return view('barang.create',[
        'breadcrumb' => (object)[
            'title' => 'Tambah barang',
            'list' => ['Home', 'barang', 'Tambah']
        ],
        
        'page' => (object)[
            'title' => 'Tambah barang baru'
        ],
        'kategori' => KategoriModel::all(),
        'barang' => BarangModel::all(),
        'activeMenu' => 'barang'
    ]);

    }
}
