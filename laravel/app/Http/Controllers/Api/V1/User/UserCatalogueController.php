<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserCatalogueRequest;
use App\Http\Requests\User\UpdateUserCatalogueRequest;
use App\Http\Resources\User\UserCatalogueCollection;
use App\Http\Resources\User\UserCatalogueResource;
use App\Repositories\Interfaces\User\UserCatalogueRepositoryInterface;
use App\Services\Interfaces\User\UserCatalogueServiceInterface;
use Illuminate\Http\JsonResponse;

class UserCatalogueController extends Controller
{
    protected $userCatalogueService;

    protected $userCatalogueRepository;

    public function __construct(
        UserCatalogueServiceInterface $userCatalogueService,
        UserCatalogueRepositoryInterface $userCatalogueRepository
    ) {
        $this->userCatalogueService = $userCatalogueService;
        $this->userCatalogueRepository = $userCatalogueRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // $this->authorize('modules', 'users.catalogues.index');

        $paginator = $this->userCatalogueService->paginate();
        $data = new UserCatalogueCollection($paginator);

        return successResponse('', $data, true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\User\StoreUserCatalogueRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserCatalogueRequest $request): JsonResponse
    {
        // $this->authorize('modules', 'users.catalogues.store');

        $response = $this->userCatalogueService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        // $this->authorize('modules', 'users.catalogues.show');

        $response = new UserCatalogueResource($this->userCatalogueRepository->findById($id));

        return successResponse('', $response, true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\UpdateUserCatalogueRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserCatalogueRequest $request, string $id): JsonResponse
    {
        // $this->authorize('modules', 'users.catalogues.update');

        $response = $this->userCatalogueService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        // $this->authorize('modules', 'users.catalogues.destroy');

        $response = $this->userCatalogueService->destroy($id);

        return handleResponse($response);
    }

    /**
     * Update permissions for the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePermissions(string $id): JsonResponse
    {
        // $this->authorize('modules', 'users.catalogues.updatePermissions');

        $response = $this->userCatalogueService->updatePermissions();

        return handleResponse($response);
    }
}
