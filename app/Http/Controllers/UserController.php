<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends Controller
{
    public function index(){
    $user = UserModel::all();
    return view('user',['data'=> $user]);
}
}
