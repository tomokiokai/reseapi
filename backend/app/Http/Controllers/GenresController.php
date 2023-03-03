<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenresController extends Controller
{
    public function getGenres()
    {
        $genres = Genre::all();
        return response()->json([
            'message' => 'Genres got successfully',
            'data' => $genres
        ], 200);
    }
}