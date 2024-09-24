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

        $select = ['id', 'user_id', 'product_variant_id',];

        $pageSize = request('pageSize');

        $withWhereHas = [
            'product_variant' => function ($q) {
                $q->where('stock', '>', 0)
                    ->whereHas('product', function ($query) {
                        $query->where('publish', 1);
                    });
            },
        ];

        $data = $this->wishListRepository->pagination(
            $select,
            [],
            $pageSize,
            [],
            [],
            ['product_variant'],
            [],
            $withWhereHas
        );

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();

            if (empty($payload)) {
                return errorResponse(__('messages.wishlist.error.auth'));
            }

            $exists = $this->wishListRepository->findByWhere(['user_id' => $payload['user_id'], 'product_variant_id' => $payload['product_variant_id']]);

            if (!empty($exists)) {
                return errorResponse(__('messages.wishlist.error.existed'));
            } else {
                $this->wishListRepository->create($payload);
                return successResponse(__('messages.wishlist.success.create'));
            }
        }, __('messages.wishlist.error.create'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        if (auth()->check()) {
            $payload['user_id'] = auth()->user()->id;
        } else {
            return [];
        }

        return $payload;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->wishListRepository->delete($id);

            return successResponse(__('messages.wishlist.success.delete'));
        }, __('messages.wishlist.error.delete'));
    }

    public function getWishListByUserId()
    {
        $user = auth()->user();

        $user->wishList = $this->wishListRepository->findByWhere(
            ['user_id' => $user->id],
            ['*'],
            [],
            true
        );

        return $user->wishList ?? collect();
    }
    public function destroyAll()
    {
        return $this->executeInTransaction(function () {

            $user = auth()->user();

            $user->wishList = $this->wishListRepository->findByWhere(
                ['user_id' => $user->id],
                ['*'],
                [],
                true
            );

            if (!$user->wishList) {
                return errorResponse(__('messages.wishlist.error.wishlist_not_found'));
            }
            foreach ($user->wishList as $item) {
                $item->delete();
            }

            return successResponse(__('messages.wishlist.success.clean'));
        }, __('messages.wishlist.error.delete'));
    }
}
