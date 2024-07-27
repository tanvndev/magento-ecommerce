<?php

namespace App\Http\Controllers\Api\V1\Attribute;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\{
    StoreAttributeRequest,
    UpdateAttributeRequest
};
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
        $response = $this->attributeService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $response = $this->attributeService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attribute = new AttributeResource($this->attributeRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $attribute ?? []
        ], ResponseEnum::OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, string $id)
    {
        $response = $this->attributeService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->attributeService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
