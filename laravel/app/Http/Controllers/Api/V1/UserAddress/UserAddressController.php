<?php

namespace App\Http\Controllers\Api\V1\UserAddress;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddress\StoreUserAddressRequest;
use App\Http\Requests\UserAddress\UpdateUserAddressRequest;
use App\Http\Resources\UserAddress\UserAddressCollection;
use App\Http\Resources\UserAddress\UserAddressResource;
use App\Repositories\Interfaces\UserAddress\UserAddressRepositoryInterface;
use App\Services\Interfaces\UserAddress\UserAddressServiceInterface;

class UserAddressController extends Controller
{
    protected $userAddressService;

    protected $userAddressRepository;

    public function __construct(
        UserAddressServiceInterface $userAddressService,
        UserAddressRepositoryInterface $userAddressRepository
    ) {
        $this->userAddressService = $userAddressService;
        $this->userAddressRepository = $userAddressRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->userAddressService->paginate();
        $data = new UserAddressCollection($paginator);

        return successResponse('', $data);
    }

    public function getByUserId()
    {
        $response = $this->userAddressService->getAddressByUserId();

        $data = new UserAddressCollection($response);

        return successResponse('', $data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserAddressRequest $request)
    {
        $response = $this->userAddressService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userAddress = new UserAddressResource($this->userAddressRepository->findById($id));

        return successResponse('', $userAddress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserAddressRequest $request, string $id)
    {
        $response = $this->userAddressService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->userAddressService->destroy($id);

        return handleResponse($response);
    }


}
