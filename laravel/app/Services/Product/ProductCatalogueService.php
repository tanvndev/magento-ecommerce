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
        $select = ['id', 'name', 'canonical', 'publish', 'parent_id', 'order', 'image'];
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
                'status' => 'success',
                'messages' => '',
                'data' => [
                    'data' => $this->formatDataToTable($data),
                    'total' => $data->total(),
                    'current_page' => $data->currentPage(),
                    'per_page' => $data->perPage(),
                ],
            ];
        }

        $data = $this->productCatalogueRepository->all($select, ['childrens'], $orderBy);

        return successResponse('', $data);
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

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->productCatalogueRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
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

            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }
}
