<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LevelModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $level = LevelModel::create($req->all());
        return response()->json($level, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(LevelModel $level)
    {
        return LevelModel::find($level);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $level_id)
    {
        $level = LevelModel::where('level_id', $level_id)->first();

        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $level->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $level
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($level_kode)
    {
        $level = LevelModel::where('level_kode', $level_kode)->first();

        if (!$level) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $level->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

}
