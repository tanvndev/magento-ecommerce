<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\StoreAttributeValueRequest;
use App\Http\Requests\Attribute\UpdateAttributeValueRequest;
use App\Http\Resources\Attribute\AttributeValueCollection;
use App\Http\Resources\Attribute\AttributeValueResource;
use App\Repositories\Interfaces\Attribute\AttributeValueRepositoryInterface;
use App\Services\Interfaces\Attribute\AttributeValueServiceInterface;

class AttributeValueController extends Controller
{
    protected $productValueService;

    protected $productValueRepository;

    public function __construct(
        AttributeValueServiceInterface $productValueService,
        AttributeValueRepositoryInterface $productValueRepository
    ) {
        $this->productValueService = $productValueService;
        $this->productValueRepository = $productValueRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->productValueService->paginate();
        $data = new AttributeValueCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeValueRequest $request)
    {
        $response = $this->productValueService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new AttributeValueResource($this->productValueRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeValueRequest $request, string $id)
    {
        $response = $this->productValueService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->productValueService->destroy($id);

        return handleResponse($response);
    }
}
