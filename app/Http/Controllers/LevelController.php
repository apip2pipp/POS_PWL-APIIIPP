<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
class LevelController extends Controller
{
    public function index()
    {
        return view('level.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar level pengguna',
                'list' => ['Home', 'Level']
            ],
            'level' => LevelModel::all(),
            'page' => (object) [
                'title' => 'Daftar level pengguna yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'level'
        ]);
    }

}