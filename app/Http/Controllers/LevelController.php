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

    public function list(Request $req) 
    {
        $level = LevelModel::select( 'level_id', 'level_kode', 'level_nama');

        if ($req->level_id) {
            $level->where('level_id', $req->level_id);
        }

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $detailUrl = route('level.show', ['id' => $level->level_id]);
                $editUrl = route('level.edit-ajax', ['id' => $level->level_id]);
                $deleteAjax = route('level.delete-ajax', ['id' => $level->level_id]);
                
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteAjax}')" class="btn btn-danger btn-sm">Hapus</button>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('level.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Level Pengguna',
                'list' => ['Home', 'Level', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah level pengguna baru'
            ],
            'activeMenu' => 'level'
        ]);
    }

    public function createAjax()
    {
        return view('level.create-ajax');
    }

    public function store(Request $req)
    {
        $req->validate([
            'level_kode' => "required|string|min:3|unique:m_level,level_kode",
            'level_nama' => 'required|string|max:100|unique:m_level,level_nama'
        ]);

        LevelModel::create([
            'level_kode' => $req->level_kode,
            'level_nama' => $req->level_nama
        ]);

        return redirect('/level')
            ->with('success', 'Data level pengguna berhasil disimpan!');
    }
}