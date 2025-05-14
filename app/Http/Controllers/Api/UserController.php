<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $user = UserModel::create($req->all());
        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserModel $user)
    {
        return UserModel::find($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id)
    {
        $user = UserModel::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $user->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        $user= UserModel::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }
}
