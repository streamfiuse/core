<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource. I.e. all contents in the content table
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $contents = Content::all();
        return response()->json(['status' => 'success', 'data' => ['contents' => ContentResource::collection($contents)]], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
            return response()->json(['status' => 'failed', 'message' => 'Invalid input!', 'validation_errors' => $validator->errors()], 422);
        }

        // Create content with the input given in the request
        $content = Content::create($request->all());

        // Check whether the creation was successful
        if (!is_null($content)) {
            return response()->json(['status' => 'success', 'message' => 'Successfully created a new content entry', 'content_entry' => $content], 201);
        }

        return response()->json(['status' => 'failed', 'message' => 'Unable to create new content entry'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param Content $content
     * @return JsonResponse
     */
    public function show(Content $content): JsonResponse
    {
        $contentResource = new ContentResource($content);
        if ($contentResource) {
            return response()->json(['status' => 'success', 'data' => $contentResource], 200);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to find specified content!'], 422);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Content $content
     * @return JsonResponse
     */
    public function update(Request $request, Content $content): JsonResponse
    {
        // when the request has no parameters (values to change) set send failed response
        if (!$request->all()) {
            return response()->json(['status' => 'failed', 'message' => 'No input given!'], 422);
        }

        // validate request
        $validator = Validator::make($request->all(), [
            'title' => 'string|unique:content,title',
            'release_date' => 'date_format:Y-m-d',
            'content_type' => 'string',
            'genre' => 'json',
            'tags' => 'json',
            'runtime' => 'integer|gt:0',
            'short_description' => 'string',
            'cast' => 'json',
            'directors' => 'json',
            'age_restriction' => 'string',
            'poster_url' => 'url',
            'youtube_trailer_url' => 'url',
            'production_company' => 'string',
            'seasons' => 'integer|gt:0',
            'average_episode_count' => 'integer|gt:0',
        ]);

        // when validation fails send failed response with errors
        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid input', 'validation_errors' => $validator->errors()], 422);
        }

        // update content
        $content->update($request->all());

        // Catch server errors
        if (is_null($content)){
            return response()->json(['status' => 'failed', 'message' => 'Unable to update record!'], 500);
        }


        // Send success response with updated content as payload
        return response()->json(['status' => 'success', 'message' => 'Record updated successfully', 'data' => new ContentResource($content)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Content $content
     * @return Response
     */
    public function destroy(Content $content)
    {
        //
    }
}
