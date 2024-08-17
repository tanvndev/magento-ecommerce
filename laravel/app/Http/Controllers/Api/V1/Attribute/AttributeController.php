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
     */
    public function index()
    {
        $paginator = $this->attributeService->paginate();
        $data = new AttributeCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $response = $this->attributeService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new AttributeResource($this->attributeRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, string $id)
    {
        $response = $this->attributeService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->attributeService->destroy($id);

        return handleResponse($response);
    }
}
