<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $req){
        //set validation
        $validator = Validator::make($req->all(),[
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'add_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(),422);
    }
    // simpan gambar ke folder public/storage/imagesu
    $req->add_image->store('images', 'public');

    $user = UserModel::create([


        'username' => $req->username,
        'nama' => $req->nama,
        'password' => bcrypt($req->password),
        'level_id' => $req->level_id,
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
