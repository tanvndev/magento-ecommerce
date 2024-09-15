<?php

namespace App\Http\Controllers\Api\V1\Cart;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CreateAndUpdateRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Resources\Cart\CartResource;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Services\Interfaces\Cart\CartServiceInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    protected $cartdRepository;

    public function __construct(
        CartServiceInterface $cartService,
        CartRepositoryInterface $cartdRepository
    ) {
        $this->cartService = $cartService;
        $this->cartdRepository = $cartdRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->cartService->getCart();

        $data = new CartCollection($response);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createOrUpdate(CreateAndUpdateRequest $request)
    {

        $response   = $this->cartService->createOrUpdate($request);

        if (is_array($response)) {
            return $response;
        }

        $data       = new CartCollection($response);

        return successResponse('', $data);
    }


        return successResponse(__('messages.cart.success.create'), $result);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->cartService->deleteOneItem($id);

        return handleResponse($response);
    }

    public function forceDestroy()
    {
        $response = $this->cartService->cleanCart();

        return handleResponse($response);
    }

    public function handleSelected(Request $request)
    {

        $response = $this->cartService->handleSelected($request);

        return handleResponse($response);
    }
}
