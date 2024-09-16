<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\WishList;

use App\Repositories\Interfaces\WishList\WishListRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\WishList\WishListServiceInterface;

class WishListService extends BaseService implements WishListServiceInterface
{
    protected $wishListRepository;

    public function __construct(
        WishListRepositoryInterface $wishListRepository,
    ) {
        $this->wishListRepository = $wishListRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'archive' => request()->boolean('archive'),
        ];

        $select = ['id', 'user_id', 'product_variant_id',];
        $pageSize = request('pageSize');

        $data = $pageSize && request('page')
            ? $this->wishListRepository->pagination($select, $condition, $pageSize,[],[],['productVariant'])
            : $this->wishListRepository->all($select,['productVariant']);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();

            $exists = $this->wishListRepository->findByWhere(['user_id' => $payload['user_id'], 'product_variant_id' => $payload['product_variant_id']]);

            if (!empty($exists)) {
                return errorResponse(__('messages.wishList.create.error'));
            } else {
                $this->wishListRepository->create($payload);
                return successResponse(__('messages.wishList.create.success'));
            }
        }, __('messages.create.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        return $payload;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->wishListRepository->delete($id);

            return successResponse(__('messages.wishList.delete.success'));
        }, __('messages.delete.error'));
    }
}
