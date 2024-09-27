<?php

namespace App\Http\Controllers\Api\V1\Permission;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Resources\Permission\PermissionCollection;
use App\Http\Resources\Permission\PermissionResource;
use App\Repositories\Interfaces\Permission\PermissionRepositoryInterface;
use App\Services\Interfaces\Permission\PermissionServiceInterface;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    protected $permissionService;

    protected $permissionRepository;

    public function __construct(
        PermissionServiceInterface $permissionService,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->permissionService = $permissionService;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // $this->authorize('modules', 'permissions.index');

        $paginator = $this->permissionService->paginate();
        $data = new PermissionCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param \App\Http\Requests\Permission\StorePermissionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        // $this->authorize('modules', 'permissions.store');

        $response = $this->permissionService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified permission.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        // $this->authorize('modules', 'permissions.show');

        $response = new PermissionResource($this->permissionRepository->findById($id));

        return successResponse('', $response, true);
    }

    /**
     * Update the specified permission in storage.
     *
     * @param \App\Http\Requests\Permission\UpdatePermissionRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePermissionRequest $request, string $id): JsonResponse
    {
        // $this->authorize('modules', 'permissions.update');

        $response = $this->permissionService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        // $this->authorize('modules', 'permissions.destroy');

        $response = $this->permissionService->destroy($id);

        return handleResponse($response, true);
    }
}
