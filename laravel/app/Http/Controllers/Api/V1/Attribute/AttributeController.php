<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\StoreAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Http\Resources\Attribute\AttributeCollection;
use App\Http\Resources\Attribute\AttributeResource;
use App\Repositories\Interfaces\Attribute\AttributeRepositoryInterface;
use App\Services\Interfaces\Attribute\AttributeServiceInterface;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    protected $attributeService;

    protected $attributeRepository;

    public function __construct(
        AttributeServiceInterface $attributeService,
        AttributeRepositoryInterface $attributeRepository
    ) {
        $this->attributeService = $attributeService;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = $this->attributeService->paginate();
        $data = new AttributeCollection($paginator);

        return successResponse('', $data, true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Attribute\StoreAttributeRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAttributeRequest $request): JsonResponse
    {
        $response = $this->attributeService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $response = new AttributeResource($this->attributeRepository->findById($id));

        return successResponse('', $response, true);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAttributeRequest  $request
     * @param  string  $id
     * @return JsonResponse
     */
    public function update(UpdateAttributeRequest $request, string $id): JsonResponse
    {
        $response = $this->attributeService->update($id);

        return handleResponse($response);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->attributeService->destroy($id);

        return handleResponse($response);
    }
}
