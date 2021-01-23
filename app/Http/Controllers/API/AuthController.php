<?php

namespace App\Http\Controllers\API;

use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function addContent(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required',
            'release_date' => 'required',
            'content_type' => 'required',
            'genre' => 'required',
            'tags' => 'required',
            'runtime' => 'required',
            'shor_description' => 'required',
            'cast' => 'required',
            'directors' => 'required',
            'age_restriction' => 'required',
            'poster_url' => 'required',
            'youtube_trailer_url' => 'required',
            'production_company' => 'required',
            'seasons' => 'required',
        ]);
    }
}
