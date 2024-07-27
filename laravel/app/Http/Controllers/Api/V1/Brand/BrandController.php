<?php

namespace App\Http\Controllers\Api\V1\Brand;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\{
    StoreBrandRequest,
    UpdateBrandRequest
};
use App\Http\Resources\Brand\BrandResource;
use App\Repositories\Interfaces\Brand\BrandRepositoryInterface;
use App\Services\Interfaces\Brand\BrandServiceInterface;

class BrandController extends Controller
{
    protected $brandService;
    protected $brandRepository;
    public function __construct(
        BrandServiceInterface $brandService,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->brandService = $brandService;
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->brandService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $response = $this->brandService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = new BrandResource($this->brandRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $brand ?? []
        ], ResponseEnum::OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $response = $this->brandService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function hanleUpdate(UpdateBrandRequest $request, string $id)
    {
        $response = $this->brandService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->brandService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
