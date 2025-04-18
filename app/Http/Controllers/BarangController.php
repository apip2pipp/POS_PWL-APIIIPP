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
        $barang = BarangModel::select('kategori_id', 'barang_id', 'barang_kode','barang_nama', 'harga_beli', 'harga_jual');

        if ($req->barang_kode) {
            $barang->where('barang_kode', $req->barang_kode);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $detailUrl = route('barang.show', ['id' => $barang->barang_id]);
                $editUrl = route('barang.edit-ajax', ['id' => $barang->barang_id]);
                $deleteUrl = route('barang.delete-ajax', ['id' => $barang->barang_id]);
                $detailUrl = route('barang.show_ajax', ['id' => $barang->barang_id]);
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
        'activeMenu' => 'barang',
    ]);

    }

    public function store(Request $req)
    {
        $req->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100|unique:m_barang,barang_nama',
            'harga_beli' => 'integer',
            'harga_jual' => 'integer',
        ]);

        BarangModel::create([
            'kategori_id' => $req->kategori_id,
            'barang_kode' => $req->barang_kode,
            'barang_nama' => $req->barang_nama,
            'harga_beli' => $req->harga_beli,
            'harga_jual' => $req->harga_jual,
            
        ]);

        return redirect('/barang')
            ->with('success', 'Data  barang berhasil disimpan!');
    }

    public function edit(string $id)
    {
        return view('barang.edit', [
            'breadcrumb' => (object) [
                'title' => 'Edit Barang',
                'list' => ['Home', 'Barang', 'Edit']
            ],
            'page' => (object) [
                'title' => 'Edit Barang'
            ],
            'kategori' => KategoriModel::all(),
            'barang' => BarangModel::find($id),
            'activeMenu' => 'barang'
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'integer',
            'harga_jual' => 'integer'
        ]);

        BarangModel::find($id)->update([
            'kategori_id' => $req->kategori_id,
            'barang_kode' => $req->barang_kode,
            'barang_nama' => $req->barang_nama,
            'harga_beli' => $req->harga_beli,
            'harga_jual' => $req->harga_jual,
        ]);

        return redirect('/barang')
            ->with('success', 'Data berhasil diubah');
    }


    public function createAjax()
    {
        return view('barang.create-ajax', [
            'barang' => BarangModel::all(),
            'kategori' => KategoriModel::all()
        ]);
    }

    public function editAjax(string $id)
    {
        return view('barang.edit-ajax', [
            'barang' => BarangModel::find($id),
            'kategori' => KategoriModel::all(),
        ]);
    }


    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'integer',
            'harga_jual' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        BarangModel::create($req->all());

        return response()->json([
            'message' => 'Data berhasil disimpan'
        ], Response::HTTP_OK);
    }


    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'kategori_id' => 'required|integer',
            'barang_kode' => "required|string|max:100|unique:m_barang,barang_kode,$id,barang_id",
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'integer',
            'harga_jual' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $barang->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function show(string $id)
    {
        return view('barang.show', [
            'breadcrumb' => (object) [
                'title' => 'Detail Barang',
                'list' => ['Home', 'Barang', 'Detail']
            ],
            'page' => (object) [
                'title' => 'Detail barang'
            ],
            'barang' => BarangModel::find($id),
            'activeMenu' => 'barang'
        ]);
    }

    public function show_ajax(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id); 
        return view('barang.show_ajax', ['barang' => $barang]);
    }

    public function destroy(string $id)
    {
        $check = BarangModel::find($id);

        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);

            return redirect('/barang')
                ->with('success', 'Data barang berhasil dihapus!');
        } catch (QueryException $e) {
            return redirect('/barang')
                ->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function confirmDeleteAjax(string $id)
    {
        $barang = BarangModel::find($id);

        return view('barang.confirm-delete-ajax', ['barang' => $barang]);
    }

    public function deleteAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $barang->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus!'
        ], Response::HTTP_OK);
    }
}
