<?php

namespace App\Http\Controllers;

use App\Models\Area;

class AreasController extends Controller
{
    public function getAreas()
    {
        $areas = Area::all();
        return response()->json([
            'message' => 'Areas got successfully',
            'data' => $areas
        ], 200);
    }
}
