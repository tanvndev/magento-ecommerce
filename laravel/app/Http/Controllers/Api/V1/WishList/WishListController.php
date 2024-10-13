<?php

namespace App\Http\Controllers\Api\V1\WishList;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CreateAndUpdateRequest;
use App\Http\Requests\WishList\StoreWishListRequest;
use App\Http\Resources\WishList\WishListCollection;
use App\Repositories\Interfaces\WishList\WishListRepositoryInterface;
use App\Services\Interfaces\WishList\WishListServiceInterface;
use Illuminate\Http\JsonResponse;

class WishListController extends Controller
{
    protected $wishListService;

    protected $wishListRepository;

    public function __construct(
        WishListServiceInterface $wishListService,
        WishListRepositoryInterface $wishListRepository,
    ) {
        $this->wishListService = $wishListService;
        $this->wishListRepository = $wishListRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $paginator = $this->wishListService->paginate();
        $data = new WishListCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Get wishlist by user.
     */
    public function getByUser(): JsonResponse
    {
        $response = $this->wishListService->getWishListByUserId();

        $data = new WishListCollection($response);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishListRequest $request): JsonResponse
    {
        $response = $this->wishListService->create();

        if (isset($response['status']) && $response['status'] == 'error') {
            return handleResponse($response);
        }

        $data = new WishListCollection($response);

        return successResponse(__('messages.wishlist.success.create'), $data, true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $response = $this->wishListService->destroy($id);

        if (isset($response['status']) && $response['status'] == 'error') {
            return handleResponse($response);
        }

        $data = new WishListCollection($response);

        return successResponse('', $data, true);
    }

    /**
     * Remove all wishlist items.
     */
    public function destroyAll(): JsonResponse
    {
        $response = $this->wishListService->destroyAll();

        return handleResponse($response);
    }

    public function addWishlistToCart(CreateAndUpdateRequest $request): JsonResponse
    {

        $response = $this->wishListService->addToCart($request);

        if (isset($response['status']) && $response['status'] == 'error') {
            return handleResponse($response);
        }

        $data = new WishListCollection($response);

        return successResponse(__('messages.cart.success.create'), $data, true);
    }

    /**
     * Send wishlist mail.
     */
    public function sendWishListMail(): JsonResponse
    {
        $response = $this->wishListService->sendWishListMail();

        return handleResponse($response);
    }
}
