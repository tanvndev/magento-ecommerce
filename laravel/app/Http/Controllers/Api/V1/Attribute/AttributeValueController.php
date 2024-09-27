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
use Illuminate\Http\JsonResponse;

class AttributeValueController extends Controller
{
    protected $attributeValueService;

    protected $attributeValueRepository;

    public function __construct(
        AttributeValueServiceInterface $attributeValueService,
        AttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $this->attributeValueService = $attributeValueService;
        $this->attributeValueRepository = $attributeValueRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = $this->attributeValueService->paginate();
        $data = new AttributeValueCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreAttributeValueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttributeValueRequest $request): JsonResponse
    {
        $response = $this->attributeValueService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = new AttributeValueResource($this->attributeValueRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAttributeValueRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAttributeValueRequest $request, string $id): JsonResponse
    {
        $response = $this->attributeValueService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->attributeValueService->destroy($id);

        return handleResponse($response);
    }
}
