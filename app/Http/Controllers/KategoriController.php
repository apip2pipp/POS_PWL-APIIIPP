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
                'title' => 'Daftar level pengguna',
                'list' => ['Home', 'Level']
            ],

            'level' => KategoriModel::all(),
            'page' => (object) [
                'title' => 'Daftar level pengguna yang terdaftar dalam sistem'
            ],
            
            'activeMenu' => 'level'
        ]);
    }
}
