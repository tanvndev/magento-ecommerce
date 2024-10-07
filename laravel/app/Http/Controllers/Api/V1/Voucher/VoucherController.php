<?php

namespace App\Http\Controllers\Api\V1\Voucher;

use App\Enums\ResponseEnum;
use App\Events\NewVoucherCreatedEvent;
use App\Events\TestEvent;
use App\Events\YourEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Http\Resources\Voucher\Client\ClientVoucherCollection;
use App\Http\Resources\Voucher\VoucherCollection;
use App\Http\Resources\Voucher\VoucherResource;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;
use App\Services\Interfaces\Voucher\VoucherServiceInterface;
use Illuminate\Http\JsonResponse;

class VoucherController extends Controller
{
    protected $voucherService;

    protected $voucherRepository;

    public function __construct(
        VoucherServiceInterface $voucherService,
        VoucherRepositoryInterface $voucherRepository
    ) {
        $this->voucherService = $voucherService;
        $this->voucherRepository = $voucherRepository;
    }

    /**
     * Get all vouchers.
     */
    public function index(): JsonResponse
    {
        $paginator = $this->voucherService->paginate();
        $data = new VoucherCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request): JsonResponse
    {
        $response = $this->voucherService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $voucher = new VoucherResource($this->voucherRepository->findById($id));

        return successResponse('', $voucher, true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, string $id): JsonResponse
    {
        $response = $this->voucherService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->voucherService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    /**
     * Get all vouchers.
     */
    public function getAllVoucher(): JsonResponse
    {
        $paginator = $this->voucherService->getAllVoucher();

        $data = new ClientVoucherCollection($paginator);
        event(new NewVoucherCreatedEvent($data));

        return successResponse('', $data, true);
    }

    /**
     * Apply a voucher to a user's cart.
     */
    public function applyVoucher(string $code): JsonResponse
    {
        $response = $this->voucherService->applyVoucher($code);

        return handleResponse($response);
    }
}
