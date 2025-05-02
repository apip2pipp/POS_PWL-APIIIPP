<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\SupplierModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        return view('barang.index', [
            'breadcrumb' => (object) [
                'title' => 'Daftar barang',
                'list' => ['Home', 'Barang']
            ],
            'kategori' => KategoriModel::all(),
            'page' => (object) [
                'title' => 'Daftar barang yang terdaftar dalam sistem'
            ],
            'activeMenu' => 'barang'
        ]);
    }

    public function list(Request $req) 
    {
        $barang = BarangModel::with(['kategori'], 'supplier')->get();

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
    
    public function create()
    {
        return view('barang.create', [
            'breadcrumb' => (object) [
                'title' => 'Tambah Barang',
                'list' => ['Home', 'Barang', 'Tambah']
            ],
            'page' => (object) [
                'title' => 'Tambah barang baru'
            ],
            'kategori' => KategoriModel::all(),
            'barang' => BarangModel::all(),
            'activeMenu' => 'barang'
        ]);
    }

    public function createAjax()
    {
        return view('barang.create-ajax', [
            
            'kategori' => KategoriModel::all()
        ]);
    }

    public function store(Request $req)
    {
        $req->validate([
            'supplier_id' => 'required|integer|min:3',
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:100|unique:m_barang,supplier_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::create([
            'supplier_id' => $req->supplier_id,
            'barang_kode' => $req->barang_kode,
            'barang_nama' => $req->barang_nama,
            'harga_beli' => $req->harga_beli,
            'harga_jual' => $req->harga_jual
        ]);

        return redirect('/barang')
            ->with('success', 'Data barang berhasil disimpan!');
    }

    public function storeAjax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            redirect('/');
        }
        
        $validator = Validator::make($req->all(), [
            'supplier_id' => 'required|integer',
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        BarangModel::create($req->all());

        return response()->json([
            'message' => 'Data supplier berhasil disimpan'
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

    public function editAjax(string $id)
    {
        return view('barang.edit-ajax', [
            'barang' => BarangModel::find($id),
            'kategori' => KategoriModel::all(),
           
        ]);
    }

    public function update(Request $req, string $id)
    {
        $req->validate([
            'supplier_id' => 'required|integer',
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        BarangModel::find($id)->update([
            'supplier_kode' => $req->supplier_kode,
            'supplier_nama' => $req->supplier_nama
        ]);

        return redirect('/barang')
            ->with('success', 'Data berhasil diubah');
    }

    public function updateAjax(Request $req, string $id)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $validator = Validator::make($req->all(), [
            'supplier_id' => 'required|integer',
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:100|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:10',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $supplier = BarangModel::find($id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        if (!$req->filled('password')) {
            $req->request->remove('password');
        }

        $supplier->update($req->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
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

    public function showImport()
    {
        return view('barang.import');
    }

    public function importData(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $rules = [
            'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = $req->file('file_barang');

        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();

        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        if (count($data) <= 1) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ], Response::HTTP_BAD_REQUEST);
        }

        foreach ($data as $row => $val) {
            if ($row > 1) {
                $insert[] = [
                    'kategori_id' => $val['A'],
                    'barang_kode' => $val['B'],
                    'barang_nama' => $val['C'],
                    'supplier_id' => $val['D'],
                    'harga_beli' => $val['E'],
                    'harga_jual' => $val['F'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        if (count($insert) > 0) {
            BarangModel::insertOrIgnore($insert);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diimport'
        ], Response::HTTP_OK);
    }

    
    
}