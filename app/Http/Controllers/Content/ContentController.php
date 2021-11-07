<?php

declare(strict_types=1);

namespace App\Http\Controllers\Content;

use App\BusinessDomain\Content\Service\ContentControllerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Content\ContentStoreRequest;
use App\Http\Requests\Content\ContentUpdateRequest;
use App\Http\Resources\ContentResource;
use App\Infrastructure\Repositories\Content\ContentRepository;
use App\Infrastructure\Traits\ProcessesJson;
use App\Models\Content;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{
    use ProcessesJson;

    private ContentControllerService $contentService;
    private ContentRepository $contentRepository;

    public function __construct(
        ContentControllerService $contentService,
        ContentRepository $contentRepository
    ) {
        $this->contentService = $contentService;
        $this->contentRepository = $contentRepository;
    }

    public function index(): JsonResponse
    {
        // Get all contents
        $contents = $this->contentRepository->findAll();

        return response()->json(
            [
            'status' => 'success',
            'data' => ContentResource::collection($contents)
            ],
        );
    }

    public function store(ContentStoreRequest $request): JsonResponse
    {
        $validator = $this->validateRequest($request);

        // Get validation errors (if any) and return them in response
        if ($validator->fails()) {
            return response()->json(
                [
                'status' => 'failed',
                'message' => 'Invalid input!',
                'validation_errors' => $validator->errors()
            ],
                422
            );
        }

        // Create content with the input given in the request
        $content = $this->contentRepository->create($request->validated());

        // Check whether the creation was successful
        if ($content !== null) {
            return response()->json(
                [
                'status' => 'success',
                'message' => 'Successfully created a new content entry',
                'content_created' => $content
                ],
                201
            );
        }

        return response()->json(
            [
            'status' => 'failed',
            'message' => 'Unable to create new content entry'
            ],
            500
        );
    }

    public function show(int $id): JsonResponse
    {
        $content = $this->contentRepository->find($id);
        if ($content !== null) {
            return response()->json(
                [
                    'status' => 'success',
                    'content' => new ContentResource($content)
                ]
            );
        }
        return response()->json(
            [
                'status' => 'failed',
                'message' => 'Could not find content with such an identifier'
            ],
            404
        );
    }

    public function showMultiple(string $idArrayJson): JsonResponse
    {
        //Check that input parameters fulfill their constraints
        $inputIsValid = $this->isJson($idArrayJson);

        if (!$inputIsValid || empty($idArrayJson)) {
            // return which constraints were not met
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Invalid input!',
                    'validation_errors' => 'Input is not a valid json string'
                ],
                422
            );
        }

        $contentIdentifiersArray = json_decode($idArrayJson);
        $responseStatusAndContentsArray = $this->contentRepository->findMultiple($contentIdentifiersArray);

        return response()->json(
            [
                'status' => $responseStatusAndContentsArray['status'] ,
                'contents' => $responseStatusAndContentsArray['models']
            ],
            $responseStatusAndContentsArray['status'] === 'success' ? 200 : 404
        );
    }

    public function update(ContentUpdateRequest $request, int $id): JsonResponse
    {
        $validator = $this->validateRequest($request);

        // Get validation errors (if any) and return them in response
        if ($validator->fails()) {
            return response()->json(
                [
                'status' => 'failed',
                'message' => 'Invalid input!',
                'validation_errors' => $validator->errors()
            ],
                422
            );
        }

        $requestParameters = $request->validated();
        // Check whether there is any input
        if (\count($requestParameters) < 1) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Missing input!'
            ], 422);
        }

        try {
            $content = $this->contentRepository->find($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Could not find content with such an identifier'
                ],
                404
            );
        }

        if ($content === null) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Could not find content with such an identifier'
                ],
                404
            );
        }

        $content = $this->contentRepository->updateContent($content, $requestParameters);

        return response()->json(
            [
            'status' => 'success',
            'altered_content' => new ContentResource($content)
            ],
        );
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->contentRepository->delete($id);
            if ($deleted === true) {
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'Content deleted successfully'
                    ]
                );
            }
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Content could not be deleted'
                ],
                500
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'Could not find content with such an identifier'
                ],
                404
            );
        } catch (\RuntimeException $e) {
            return response()->json(
                [
                    'status' => 'failed',
                    'message' => 'An unknown error occurred during deletion'
                ],
                500
            );
        }
    }
}
