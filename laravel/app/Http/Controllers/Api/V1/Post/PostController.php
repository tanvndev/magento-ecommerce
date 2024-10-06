<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\Client\ClientPostCollection;
use App\Http\Resources\Post\Client\ClientPostResource;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use App\Services\Interfaces\Post\PostServiceInterface;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    protected $postService;

    protected $postRepository;

    public function __construct(
        PostServiceInterface $postService,
        PostRepositoryInterface $postRepository
    ) {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
    }


    public function index(): JsonResponse
    {
        $paginator = $this->postService->paginate();
        $data = new PostCollection($paginator);
        return successResponse('', $data, true);
    }


    public function store(StorePostRequest $request): JsonResponse
    {
        $response = $this->postService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }


    public function show(string $id): JsonResponse
    {
        $post = new PostResource($this->postRepository->findById($id));

        return successResponse('', $post, true);
    }


    public function update(UpdatePostRequest $request, string $id): JsonResponse
    {
        $response = $this->postService->update($id);

        return handleResponse($response);
    }


    public function destroy(string $id): JsonResponse
    {
        $response = $this->postService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    public function getAllPost(): JsonResponse
    {
        $paginator = $this->postService->getAllPost();

        $data = new ClientPostCollection($paginator);

        return successResponse('', $data, true);
    }

    public function getPostByCanonical(string $canonical): JsonResponse
    {
        $response = $this->postService->getPost(['canonical' => $canonical]);

        $data = new ClientPostResource($response);

        return successResponse('', $data, true);
    }
}
