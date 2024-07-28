<?php

namespace App\Http\Controllers\Api\V1\Tax;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tax\{
    StoreTaxRequest,
    UpdateTaxRequest
};
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
        $response = $this->taxService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaxRequest $request)
    {
        $response = $this->taxService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tax = new TaxResource($this->taxRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $tax ?? []
        ], ResponseEnum::OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaxRequest $request, string $id)
    {
        $response = $this->taxService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->taxService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
