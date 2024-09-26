<?php

namespace App\Http\Controllers\Api\V1\WishList;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CreateAndUpdateRequest;
use App\Http\Requests\WishList\StoreWishListRequest;
use App\Http\Requests\WishList\UpdateWishListRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Resources\WishList\WishListCollection;
use App\Http\Resources\WishList\WishListResource;
use App\Repositories\Interfaces\Cart\CartRepositoryInterface;
use App\Repositories\Interfaces\WishList\WishListRepositoryInterface;
use App\Services\Interfaces\Cart\CartServiceInterface;
use App\Services\Interfaces\WishList\WishListServiceInterface;

class WishListController extends Controller
{
    protected $wishListService;

    protected $wishListRepository;

    protected $cartService;

    protected $cartdRepository;

    public function __construct(
        WishListServiceInterface $wishListService,
        WishListRepositoryInterface $wishListRepository,
        CartServiceInterface $cartService,
        CartRepositoryInterface $cartdRepository
    ) {
        $this->wishListService = $wishListService;
        $this->wishListRepository = $wishListRepository;
        $this->cartService = $cartService;
        $this->cartdRepository = $cartdRepository;
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $paginator = $this->wishListService->paginate();
        $data = new WishListCollection($paginator);

        return $paginator;
    }
    public function getByUserId()
    {
        $response = $this->wishListService->getWishListByUserId();

        $data = new WishListCollection($response);

        return successResponse('', $data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishListRequest $request)
    {
        $response = $this->wishListService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->wishListService->destroy($id);

        return handleResponse($response);
    }

    public function destroyAll()
    {
        $response = $this->wishListService->destroyAll();

        return handleResponse($response);
    }

    public function createOrUpdateCart(CreateAndUpdateRequest $request)
    {

        $response = $this->cartService->createOrUpdate($request);

        if (is_array($response)) {
            return $response;
        }

        $data = new CartCollection($response);

        return successResponse(__('messages.cart.success.create'), $data);
    }
}
