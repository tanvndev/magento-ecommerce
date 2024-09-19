<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Voucher;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Http\Resources\Voucher\Client\ClientVoucherCollection;
use App\Http\Resources\Voucher\VoucherCollection;
use App\Http\Resources\Voucher\VoucherResource;
use App\Repositories\Interfaces\Voucher\VoucherRepositoryInterface;
use App\Services\Interfaces\Voucher\VoucherServiceInterface;

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->voucherService->paginate();
        $data = new VoucherCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        $response = $this->voucherService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Voucher = new VoucherResource($this->voucherRepository->findById($id));

        return successResponse('', $Voucher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, string $id)
    {
        $response = $this->voucherService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->voucherService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    public function getAllVoucher()
    {
        $paginator = $this->voucherService->getAllVoucher();

        $data = new ClientVoucherCollection($paginator);

        return successResponse('', $data);
    }
}
