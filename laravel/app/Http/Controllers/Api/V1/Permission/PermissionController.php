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
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('modules', 'permissions.index');

        $paginator = $this->permissionService->paginate();
        $data = new PermissionCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        // $this->authorize('modules', 'permissions.store');

        $response = $this->permissionService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $this->authorize('modules', 'permissions.show');

        $response = new PermissionResource($this->permissionRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, string $id)
    {
        // $this->authorize('modules', 'permissions.update');

        $response = $this->permissionService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize('modules', 'permissions.destroy');

        $response = $this->permissionService->destroy($id);

        return handleResponse($response);
    }
}
