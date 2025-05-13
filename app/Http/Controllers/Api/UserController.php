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
    public function update(Request $req, UserModel $user)
    {
        $user->update($req->all());
        return UserModel::find($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserModel $user)
    {
        $user->delete();

        return response()->json([
            "message" => "Data successfully deleted"
        ]);
    }
}
