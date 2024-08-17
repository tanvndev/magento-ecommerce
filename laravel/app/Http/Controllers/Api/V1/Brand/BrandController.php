<?php

namespace App\Http\Controllers\Api\V1\Brand;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Resources\Brand\BrandCollection;
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
        $paginator = $this->brandService->paginate();
        $data = new BrandCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $response = $this->brandService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = new BrandResource($this->brandRepository->findById($id));

        return successResponse('', $brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        $response = $this->brandService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->brandService->destroy($id);

        return handleResponse($response);
    }
}
