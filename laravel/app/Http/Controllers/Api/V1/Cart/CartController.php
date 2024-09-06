<?php

namespace App\Http\Controllers\Api\V1\Cart;

use Attribute;
use App\Enums\ResponseEnum;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Cart\CreateAndUpdateRequest;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;

class CartController extends Controller
{
    protected $CartdService;

    protected $CartdRepository;

    public function __construct(
        CartServiceInterface $CartdService,
        CartRepositoryInterface $CartdRepository
    ) {
        $this->CartdService = $CartdService;
        $this->CartdRepository = $CartdRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->CartdService->getCart();

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAndUpdateRequest $request)
    {
        $response = $this->CartdService->CreateOrUpdate($request);

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $Cartd = new CartResource($this->CartdRepository->findById($id));

    //     return successResponse('', $Cartd);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateAndUpdateRequest $request)
    {
        $response = $this->CartdService->CreateOrUpdate($request);
        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->CartdService->deleteOneItem($id);

        return handleResponse($response);
    }
}
