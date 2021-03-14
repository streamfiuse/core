<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Service\ContentControllerService;
use App\Http\Requests\ContentStoreRequest;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    private ContentControllerService $contentControllerService;

    public function __construct(ContentControllerService $contentControllerService)
    {
        $this->contentControllerService = $contentControllerService;
    }

    public function index(): JsonResponse
    {
        // Get all contents
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

    public function showMultiple(Request $request): JsonResponse
    {
        //Check that input parameters fulfill their constraints
        $validator = Validator::make($request->all(), [
            'content_ids'  =>  'required|json',
        ]);

        if ($validator->fails()) {
            // return which constraints were not met
            return response()->json(['status' => 'failed', 'message' => 'Invalid input!', 'validation_errors' => $validator->errors()], 422);
        }

        $contentIdentifiersArray = $this->contentControllerService->getIdentifiersArrayFromRequest($request);
        $responseStatusAndContentsArray = $this->contentControllerService->getContentsByIdentifiers($contentIdentifiersArray);

        return response()->json(['status' => $responseStatusAndContentsArray['status'] , 'contents' => $responseStatusAndContentsArray['contents']]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $requestParameters = $request->all();
        // Check whether there is any input
        if (sizeof($requestParameters) < 1) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Missing input!'
            ], 422);
        }

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
            $content = Content::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['status' => 'failed', 'message' => 'Could not find content with such an identifier'], 404);
        }

        foreach ($requestParameters as $parameterKey => $parameterValue) {
            $content->setAttribute($parameterKey, $parameterValue);
        }

        $content->setAttribute('updated_at', Date::now());

        $content->save();

        return response()->json([
            'status' => 'success',
            'altered_content' => new ContentResource($content)
        ], 200);
    }

    public function destroy(int $id)
    {
        try {
            $content = Content::findOrFail($id);
            $deleted = $content->delete();

            if ($deleted === true) {
                return response()->json(['status' => 'success', 'message' => 'Content deleted successfully'], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'Content could not be deleted'], 500);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'failed', 'message' => 'Could not find content with such an identifier'], 404);
        }
    }

    private function validateContentRequest(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), $request->rules());
    }
}
