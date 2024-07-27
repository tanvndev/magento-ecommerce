<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{
    StoreUserCatalogueRequest,
    UpdateUserCatalogueRequest
};
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
        $this->authorize('modules', 'users.catalogues.index');
        $response = $this->userCatalogueService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserCatalogueRequest $request)
    {
        $this->authorize('modules', 'users.catalogues.store');
        $response = $this->userCatalogueService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('modules', 'users.catalogues.show');
        $userCatalogue = new UserCatalogueResource($this->userCatalogueRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $userCatalogue ?? []
        ], ResponseEnum::OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserCatalogueRequest $request, string $id)
    {
        $this->authorize('modules', 'users.catalogues.update');
        $response = $this->userCatalogueService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('modules', 'users.catalogues.destroy');
        $response = $this->userCatalogueService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    public function updatePermissions(string $id)
    {
        $this->authorize('modules', 'users.catalogues.updatePermissions');
        $response = $this->userCatalogueService->updatePermissions();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
