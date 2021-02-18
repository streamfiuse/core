<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function index(): JsonResponse
    {
        $contents = Content::all();

        return response()->json([
            'status' => 'success',
            'data' => ContentResource::collection($contents)
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:content,title',
            'release_date' => 'required|date_format:Y-m-d',
            'content_type' => 'required|string',
            'genre' => 'required|json',
            'tags' => 'required|json',
            'runtime' => 'required|integer|gt:0',
            'short_description' => 'required|string',
            'cast' => 'required|json',
            'directors' => 'required|json',
            'age_restriction' => 'required|string',
            'poster_url' => 'required|url',
            'youtube_trailer_url' => 'required|url',
            'production_company' => 'required|string',
            'seasons' => 'required|integer|gt:0',
            'average_episode_count' => 'required|integer|gt:0',
        ]);

        // Validate
        if ($validator->fails()) {

            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid input!',
                'validation_errors' => $validator->errors()
            ],
                422);

        }

        // Create content with the input given in the request
        $content = Content::create($request->all());

        // Check whether the creation was successful
        if (!is_null($content)) {

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully created a new content entry',
                'content_created' => $content],
                201);

        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Unable to create new content entry'
        ],
            500);

    }

    public function show(Content $content)
    {

    }

    public function update(Request $request, Content $content)
    {

    }

    public function destroy(Content $content)
    {

    }
}
