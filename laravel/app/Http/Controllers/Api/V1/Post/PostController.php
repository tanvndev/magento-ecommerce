<?php

namespace App\Http\Controllers\Api\V1\Post;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use App\Services\Interfaces\Post\PostServiceInterface;

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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = $this->postService->paginate();
        $data = new PostCollection($paginator);
        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $response = $this->postService->create();

        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = new PostResource($this->postRepository->findById($id));

        return successResponse('', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $response = $this->postService->update($id);

        return handleResponse($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->postService->destroy($id);

        return handleResponse($response);
    }

    // CLIENT API //

    public function getAllPost()
    {
        $paginator = $this->postService->getAllPost();

        $data = new PostCollection($paginator);

        return successResponse('', $data);
    }
}
