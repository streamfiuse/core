<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentStoreRequest;
use App\Http\Requests\ContentUpdateRequest;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function store(ContentStoreRequest $request): JsonResponse
    {
        $validator = $this->validateContentRequest($request);

        // Get validation errors (if any) and return them in response
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

    public function show(int $id): JsonResponse
    {
        try {
            $content = Content::findOrFail($id);
            return response()->json(['status' => 'success', 'content' => new ContentResource($content)]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'failed', 'message' => 'Could not find content with such an identifier'], 404);
        }
    }

    public function update(ContentUpdateRequest $request, int $id): JsonResponse
    {
        $validator = $this->validateContentRequest($request);

        // Get validation errors (if any) and return them in response
        if ($validator->fails()) {

            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid input!',
                'validation_errors' => $validator->errors()
            ],
                422);

        }

        try {

        } catch (ModelNotFoundException $exception) {

        }
    }

    public function destroy(Content $content)
    {

    }

    private function validateContentRequest(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), $request->rules());
    }
}
