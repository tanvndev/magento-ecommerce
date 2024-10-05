<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Post;

use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Post\PostServiceInterface;

class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
    ) {
        $this->postRepository = $postRepository;
    }

    public function paginate()
    {
        $request = request();

        $select = [
            'id',
            'user_id',
            'name',
            'image',
            'description',
            'content',
            'canonical',
            'icon',
            'order',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'publish',
        ];


        $orderBy = ['id' => 'desc'];
        $relations = ['user'];
        $condition = [
            'search'  => addslashes($request->search),
            'publish' => $request->publish,
            'archive' => $request->boolean('archive'),
        ];

        $pageSize = $request->pageSize;

        $data = $this->postRepository->pagination($select, $condition, $pageSize, $orderBy, [], $relations);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = $this->preparePayload();

            $this->postRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->postRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->postRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        return $payload;
    }

    // CLIENT API //

    public function getAllPost()
    {
        $request = request();

        $select = [
            'id',
            'name',
            'code',
            'items',
            'setting',
            'publish',
        ];

        $condition = ['publish' => 1];

        $orderBy = ['id' => 'DESC'];

        $data = $this->postRepository->findByWhere($condition, $select, [], true, $orderBy);

        return $data;
    }
}
