<?php

namespace App\Http\Controllers\Api\V1\WishList;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\WishList\StoreWishListRequest;
use App\Http\Requests\WishList\UpdateWishListRequest;
use App\Http\Resources\WishList\WishListCollection;
use App\Http\Resources\WishList\WishListResource;
use App\Repositories\Interfaces\WishList\WishListRepositoryInterface;
use App\Services\Interfaces\WishList\WishListServiceInterface;

class WishListController extends Controller
{
    protected $wishListService;

    protected $wishListRepository;

    public function __construct(
        WishListServiceInterface $wishListService,
        WishListRepositoryInterface $wishListRepository
    ) {
        $this->wishListService = $wishListService;
        $this->wishListRepository = $wishListRepository;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWishListRequest $request)
    {
        $response = $this->wishListService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     $wishList = new WishListResource($this->wishListRepository->findById($id));

    //     return successResponse('', $wishList);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateWishListRequest $request, string $id)
    // {
    //     $response = $this->wishListService->update($id);

    //     return handleResponse($response);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->wishListService->destroy($id);

        return handleResponse($response);
    }
}
