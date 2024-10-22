<?php

namespace App\Http\Controllers\Api\V1\FlashSale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlashSale\FlashSaleStoreRequest;
use App\Services\Interfaces\FlashSale\FlashSaleServiceInterface;
use App\Repositories\Interfaces\FlashSale\FlashSaleRepositoryInterface;

class FlashSaleController extends Controller
{
    protected $flashSaleService;

    protected $flashSaleRepository;
    function __construct(FlashSaleServiceInterface $flashSaleService,  FlashSaleRepositoryInterface $flashSaleRepository)
    {
        $this->flashSaleService = $flashSaleService;
        $this->flashSaleRepository = $flashSaleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FlashSaleStoreRequest $request)
    {
        $data = $this->flashSaleService->store($request->all());

        return successResponse('', $data, true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $data = $this->flashSaleService->update($id, $request->all());

        return successResponse('', $data, true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
