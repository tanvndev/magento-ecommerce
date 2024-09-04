<?php

namespace App\Http\Controllers\Api\V1\ShippingMethod;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingMethod\StoreShippingMethodRequest;
use App\Http\Requests\ShippingMethod\UpdateShippingMethodRequest;
use App\Http\Resources\ShippingMethod\ShippingMethodCollection;
use App\Http\Resources\ShippingMethod\ShippingMethodResource;
use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;
use App\Services\Interfaces\ShippingMethod\ShippingMethodServiceInterface;

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->shippingMethodService->paginate();
        $data = new ShippingMethodCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShippingMethodRequest $request)
    {
        $response = $this->shippingMethodService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shippingMethod = new ShippingMethodResource($this->shippingMethodRepository->findById($id));

        return successResponse('', $shippingMethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippingMethodRequest $request, string $id)
    {
        $response = $this->shippingMethodService->update($id);

        return handleResponse($response);
    }
}
