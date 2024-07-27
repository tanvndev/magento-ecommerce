<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{
    StoreUserRequest,
    UpdateUserRequest
};
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
        $this->authorize('modules', 'users.index');
        $response = $this->userService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('modules', 'users.store');
        $response = $this->userService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('modules', 'users.show');
        $user = new UserResource($this->userRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $user ?? []
        ], ResponseEnum::OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $this->authorize('modules', 'users.update');
        $response = $this->userService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('modules', 'users.destroy');
        $response = $this->userService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
