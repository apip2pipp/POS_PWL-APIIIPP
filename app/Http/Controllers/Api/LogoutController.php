<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {

        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            return response()->json([
                'succes' => true,
                'message' => 'Logout Succesfull',
            ],200);
        }
    }
}
