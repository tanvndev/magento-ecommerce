<?php

namespace App\Http\Controllers\Api\V1\ShippingMethod;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingMethod\StoreShippingMethodRequest;
use App\Http\Requests\ShippingMethod\UpdateShippingMethodRequest;
use App\Http\Resources\ShippingMethod\Client\ClientShippingMethodCollection;
use App\Http\Resources\ShippingMethod\ShippingMethodCollection;
use App\Http\Resources\ShippingMethod\ShippingMethodResource;
use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;
use App\Services\Interfaces\ShippingMethod\ShippingMethodServiceInterface;
use Illuminate\Http\JsonResponse;

class ShippingMethodController extends Controller
{
    protected $shippingMethodService;

    protected $shippingMethodRepository;

    public function __construct(
        ShippingMethodServiceInterface $shippingMethodService,
        ShippingMethodRepositoryInterface $shippingMethodRepository
    ) {
        $this->shippingMethodService = $shippingMethodService;
        $this->shippingMethodRepository = $shippingMethodRepository;
    }

    /**
     * Display a listing of the shipping methods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginator = $this->shippingMethodService->paginate();
        $data = new ShippingMethodCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created shipping method in storage.
     *
     * @param \App\Http\Requests\ShippingMethod\StoreShippingMethodRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreShippingMethodRequest $request): JsonResponse
    {
        $response = $this->shippingMethodService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified shipping method.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $shippingMethod = new ShippingMethodResource($this->shippingMethodRepository->findById($id));

        return successResponse('', $shippingMethod, true);
    }

    /**
     * Update the specified shipping method in storage.
     *
     * @param \App\Http\Requests\ShippingMethod\UpdateShippingMethodRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateShippingMethodRequest $request, string $id): JsonResponse
    {
        $response = $this->shippingMethodService->update($id);

        return handleResponse($response);
    }

    // API CLIENT //

    /**
     * Get all available shipping methods for clients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllShippingMethod(): JsonResponse
    {
        $shippingMethods = $this->shippingMethodService->getAllShippingMethod();

        $data = new ClientShippingMethodCollection($shippingMethods);

        return successResponse('', $data, true);
    }

    /**
     * Get shipping methods available for the specified product variant.
     *
     * @param string $productVariantIds
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShippingMethodByProductVariant(string $productVariantIds): JsonResponse
    {
        $shippingMethods = $this->shippingMethodService->getShippingMethodByProductVariant($productVariantIds);

        $data = new ClientShippingMethodCollection($shippingMethods);

        return successResponse('', $data, true);
    }
}
