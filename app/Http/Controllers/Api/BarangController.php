<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $req)
    {
        $level = BarangModel::create($req->all());
        return response()->json($level, Response::HTTP_CREATED);
    }

    public function show(BarangModel $barang)
    {
        return BarangModel::find($barang);
    }

    public function update(Request $request, $barang_id)
    {
        $barang = BarangModel::where('barang_id', $barang_id)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $barang
        ]);
    }

    public function destroy($barang_kode)
    {
        $barang = BarangModel::where('barang_kode', $barang_kode)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

    public function add_image(Request $req){
    $validator = Validator::make($req->all(),[
            'kategori_id' => 'required',
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'add_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(),422);
    }

    $user = BarangModel::create([
        'kategori_id' => $req->kategori_id,
        'barang_kode' => $req->barang_kode,
        'barang_nama' => $req->barang_nama,
        'harga_beli' => $req->harga_beli,
        'harga_jual' => $req->harga_beli,
        'add_image' => $req->add_image->hashName(),
    ]);

    //return response JSON user is created
    if ($user) {
       return response()->json([
        'success' => true,
        'user' => $user,
       ],201);
    }

    //return JSON process insert failed
    return response()->json([
        'success' =>false,
    ],409);
    }
}
