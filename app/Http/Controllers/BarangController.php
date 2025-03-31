<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BarangModel;
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
}
