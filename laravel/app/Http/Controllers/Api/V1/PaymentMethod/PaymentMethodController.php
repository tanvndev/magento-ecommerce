<?php

namespace App\Http\Controllers\Api\V1\PaymentMethod;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\StorePaymentMethodRequest;
use App\Http\Requests\PaymentMethod\UpdatePaymentMethodRequest;
use App\Http\Resources\PaymentMethod\PaymentMethodCollection;
use App\Http\Resources\PaymentMethod\PaymentMethodResource;
use App\Repositories\Interfaces\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Services\Interfaces\PaymentMethod\PaymentMethodServiceInterface;

class PaymentMethodController extends Controller
{
    protected $paymentMethodService;

    protected $paymentMethodRepository;

    public function __construct(
        PaymentMethodServiceInterface $paymentMethodService,
        PaymentMethodRepositoryInterface $paymentMethodRepository
    ) {
        $this->paymentMethodService = $paymentMethodService;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->paymentMethodService->paginate();
        $data = new PaymentMethodCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentMethodRequest $request)
    {
        $response = $this->paymentMethodService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = new PaymentMethodResource($this->paymentMethodRepository->findById($id));

        return successResponse('', $paymentMethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentMethodRequest $request, string $id)
    {
        $response = $this->paymentMethodService->update($id);

        return handleResponse($response);
    }
}
