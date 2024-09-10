<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Product;

use App\Repositories\Interfaces\Product\ProductCatalogueRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductCatalogueServiceInterface;

class ProductCatalogueService extends BaseService implements ProductCatalogueServiceInterface
{
    protected $productCatalogueRepository;

    protected $productRepository;

    public function __construct(
        ProductCatalogueRepositoryInterface $productCatalogueRepository,
    ) {
        $this->productCatalogueRepository = $productCatalogueRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];
        $select = ['id', 'name', 'canonical', 'publish', 'parent_id', 'order', 'image', 'is_featured'];
        $pageSize = request('pageSize');
        $orderBy = ['order' => 'desc'];

        if ($pageSize && request('page')) {
            $data = $this->productCatalogueRepository->pagination(
                $select,
                $condition,
                $pageSize,
                $orderBy
            );

            return [
                'data' => $this->formatDataToTable($data),
                'total' => $data->total(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
            ];
        }

        $data = $this->productCatalogueRepository->findByWhere(['publish' => 1], $select, ['childrens'], true, $orderBy);

        return $data;
    }

    private function formatDataToTable($data, $parentId = 0)
    {
        $formattedData = [];
        $dataById = [];

        // Index data by ID for faster lookup
        foreach ($data as $item) {
            $dataById[$item->id] = $item;
        }

        foreach ($dataById as $item) {
            if ($item->parent_id == $parentId) {
                $formattedItem = [
                    'key' => $item->id,
                    'id' => $item->id,
                    'name' => $item->name,
                    'canonical' => $item->canonical,
                    'publish' => $item->publish,
                    'is_featured' => $item->is_featured,
                    'parent_id' => $item->parent_id,
                    'order' => $item->order,
                    'image' => $item->image,
                    'children' => $this->formatDataToTable($dataById, $item->id),
                ];
                $formattedData[] = $formattedItem;
            }
        }

        return $formattedData;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->productCatalogueRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->productCatalogueRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        $payload['parent_id'] = $payload['parent_id'] ?? 0 ?: null;
        $payload = $this->createSEO($payload);

        return $payload;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->productCatalogueRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    // CLIENT API //
    public function list()
    {
        $condition = [
            'where' => [
                'publish' => 1,
                'is_featured' => 1,
            ],
        ];
        $select = ['id', 'name', 'canonical', 'publish', 'parent_id', 'order', 'image', 'is_featured'];
        $orderBy = ['order' => 'desc'];

        $data = $this->productCatalogueRepository->pagination(
            $select,
            $condition,
            20,
            $orderBy,
            [],
            ['childrens']
        );

        return $data;
    }
}
