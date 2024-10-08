<?php

namespace App\Http\Controllers\Api\V1\Upload;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\Upload\UploadServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $uploadService;

    public function __construct(
        UploadServiceInterface $uploadService
    ) {
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of the uploaded resources.
     */
    public function index(): JsonResponse
    {
        $response = $this->uploadService->paginate();

        return handleResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->uploadService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->uploadService->destroy($id);

        return handleResponse($response);
    }
}
