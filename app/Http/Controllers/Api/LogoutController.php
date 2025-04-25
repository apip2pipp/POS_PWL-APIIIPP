<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        // Hapus token akses saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out Succes'
        ]);
    }
}