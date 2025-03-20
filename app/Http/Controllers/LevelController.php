<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'User',
            'list' => ['Home', 'User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user';

        $level = LevelModel::all();
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'level' => $level, 'activeMenu' => $activeMenu]);

    }
}
