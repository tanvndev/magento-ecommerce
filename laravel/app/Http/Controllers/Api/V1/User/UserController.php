<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use App\Services\Interfaces\User\UserServiceInterface;

class UserController extends Controller
{
    protected $userService;

    protected $userRepository;

    public function __construct(
        UserServiceInterface $userService,
        UserRepositoryInterface $userRepository
    ) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('modules', 'users.index');

        $paginator = $this->userService->paginate();
        $data = new UserCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // $this->authorize('modules', 'users.store');

        $response = $this->userService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $this->authorize('modules', 'users.show');

        $response = new UserResource($this->userRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        // $this->authorize('modules', 'users.update');

        $response = $this->userService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize('modules', 'users.destroy');

        $response = $this->userService->destroy($id);

        return handleResponse($response);
    }
}
