<?php

namespace App\Http\Controllers\Api\V1\Tax;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tax\StoreTaxRequest;
use App\Http\Requests\Tax\UpdateTaxRequest;
use App\Http\Resources\Tax\TaxCollection;
use App\Http\Resources\Tax\TaxResource;
use App\Repositories\Interfaces\Tax\TaxRepositoryInterface;
use App\Services\Interfaces\Tax\TaxServiceInterface;

class TaxController extends Controller
{
    protected $taxService;

    protected $taxRepository;

    public function __construct(
        TaxServiceInterface $taxService,
        TaxRepositoryInterface $taxRepository
    ) {
        $this->taxService = $taxService;
        $this->taxRepository = $taxRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->taxService->paginate();
        $data = new TaxCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxRequest $request)
    {
        $response = $this->taxService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = new TaxResource($this->taxRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxRequest $request, string $id)
    {
        $response = $this->taxService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->taxService->destroy($id);

        return handleResponse($response);
    }
}
