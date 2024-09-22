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
     */
    public function index()
    {
        // $this->authorize('modules', 'users.catalogues.index');

        $paginator = $this->userCatalogueService->paginate();
        $data = new UserCatalogueCollection($paginator);

        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserCatalogueRequest $request)
    {
        // $this->authorize('modules', 'users.catalogues.store');

        $response = $this->userCatalogueService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $this->authorize('modules', 'users.catalogues.show');

        $response = new UserCatalogueResource($this->userCatalogueRepository->findById($id));

        return successResponse('', $response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserCatalogueRequest $request, string $id)
    {
        // $this->authorize('modules', 'users.catalogues.update');

        $response = $this->userCatalogueService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize('modules', 'users.catalogues.destroy');

        $response = $this->userCatalogueService->destroy($id);

        return handleResponse($response);
    }

    public function updatePermissions(string $id)
    {
        // $this->authorize('modules', 'users.catalogues.updatePermissions');

        $response = $this->userCatalogueService->updatePermissions();

        return handleResponse($response);
    }
}
