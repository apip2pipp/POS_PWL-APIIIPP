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
                $detailUrl = route('kategori.show_ajax', ['id' => $kategori->kategori_id]);
                return <<<HTML
                <button onclick="modalAction('{$detailUrl}')" class="btn btn-info btn-sm">Detail</button>
                <button onclick="modalAction('{$editUrl}')" class="btn btn-warning btn-sm">Edit</button>
                <button onclick="modalAction('{$deleteUrl}')" class="btn btn-danger btn-sm">Hapus</button>
                HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('kategori.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Kategori Barang',
                'list' => ['Home', 'Kategori', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah kategori barang baru'
            ],
            'kategori' => KategoriModel::all(),
            'activeMenu' => 'kategori'
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode",
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama'
        ]);

        KategoriModel::create([
            'kategori_kode' => $req->kategori_kode,
            'kategori_nama' => $req->kategori_nama
        ]);

        return redirect('/kategori')
            ->with('success', 'Data kategori barang berhasil disimpan!');
    }

    public function show(string $id)
    {
        return view('kategori.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Kategori Barang',
                'list' => ['Home', 'Kategori', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail kategori barang'
            ],
            'kategori' => KategoriModel::find($id),
            'activeMenu' => 'kategori'
        ]);
    }

    public function show_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.show_ajax', ['kategori' => $kategori]);

        
    }

    public function edit(string $id)
    {
        return view('kategori.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit Kategori Barang',
                'list' => ['Home', 'Kategori', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit Kategori Barang'
            ],
            'kategori' => KategoriModel::find($id),
            'activeMenu' => 'kategori'
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode,$id,kategori_id",
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $req->kategori_kode,
            'kategori_nama' => $req->kategori_nama
        ]);

        return redirect('/kategori')
            ->with('success', 'Data berhasil diubah');
    }

    public function createAjax()
    {
        return view('kategori.create-ajax');
    }

    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode",
            'kategori_nama' => 'required|string|max:100|unique:m_kategori,kategori_nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        KategoriModel::create($req->all());

        return response()->json([
            'message' => 'Data kategori berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function editAjax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.edit-ajax', [
            'kategori' => $kategori
        ]);
    }

    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'kategori_kode' => "required|string|min:3|unique:m_kategori,kategori_kode,$id,kategori_id",
            'kategori_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $kategori->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);

        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori barang tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);

            return redirect('/kategori')
                ->with('success', 'Data kategori barang berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/kategori')
                ->with('error', 'Data kategori barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirmDeleteAjax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm-delete-ajax', ['kategori' => $kategori]);
    }

    public function deleteAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $kategori->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], Response::HTTP_OK);
    }
}
