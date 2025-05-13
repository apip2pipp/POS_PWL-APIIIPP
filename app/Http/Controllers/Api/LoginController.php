<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $req){
    //set validation
    $validator = Validator::make($req->all(),[
        'username' => 'required',
        'password' => 'required'
    ]);

    //if validation fails
    if ($validator->fails()) {
        return response()->json($validator->errors(),422);
    }

    //get credentials from request
    $credentials = $req->only('username','password');

    //if auth fails
    if (!$token = auth()->guard('api')->attempt($credentials)) {
        return response()->json([
            'succes' => false,
            'message'=> 'username atau passsword anda salah'
        ],401);
    }

    //If AUTH SUCCES
    return response()->json([
        'succes' => true,
        'user'   => auth()->guard('api')->user(),
        'token'  => $token
    ],200);

    }
}
