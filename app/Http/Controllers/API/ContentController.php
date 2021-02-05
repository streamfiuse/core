<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::all();
        return response(['status' => 'success', 'data' => ['contents' => ContentResource::collection($contents)]], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
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

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid input!', 'validation_errors' => $validator->errors()], 422);
        }

        $content = Content::create($request->all());
        if (!is_null($content)) {
            return response()->json(['status' => 'success', 'message' => 'Successfully created a new content entry', 'content_entry' => $content], 201);
        }

        return response()->json(['status' => 'failed', 'message' => 'Unable to create new content entry'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
