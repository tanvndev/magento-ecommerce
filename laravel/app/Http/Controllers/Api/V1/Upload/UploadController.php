<?php

namespace App\Http\Controllers\Api\V1\Upload;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\Upload\UploadServiceInterface;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $uploadService;
    public function __construct(
        UploadServiceInterface $uploadService
    ) {
        $this->uploadService = $uploadService;
    }
    public function index()
    {
        $response = $this->uploadService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = $this->uploadService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->uploadService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
