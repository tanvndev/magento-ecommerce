<?php



// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\ShippingMethod;

use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Repositories\Interfaces\ShippingMethod\ShippingMethodRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\ShippingMethod\ShippingMethodServiceInterface;

class ShippingMethodService extends BaseService implements ShippingMethodServiceInterface
{
    public function __construct(
        protected ShippingMethodRepositoryInterface $shippingMethodRepository,
        protected ProductVariantRepositoryInterface $productVariantRepository
    ) {}

    public function paginate()
    {
        $select = ['id', 'name', 'publish', 'description', 'base_cost', 'image'];
        $data = $this->shippingMethodRepository->all($select);

        return $data;
    }

    public function list()
    {
        $data = $this->shippingMethodRepository->findByWhere(['publish' => 1]);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->shippingMethodRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->shippingMethodRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        return $payload;
    }

    // API CLIENT //

    public function getAllShippingMethod()
    {
        $shippingMethods = $this->shippingMethodRepository->findByWhere(
            ['publish' => 1],
            ['*'],
            [],
            true
        );

        return $shippingMethods;
    }

    public function getShippingMethodByProductVariant(string $productVariantIds)
    {

        $productVariantIds = explode(',', $productVariantIds);

        $productVariants = $this->productVariantRepository->findByWhereIn(
            $productVariantIds,
            'id',
            ['id', 'product_id'],
            [
                'product' => function ($q) {
                    $q->select('id', 'shipping_ids');
                }
            ]
        );

        if (empty($productVariants)) {
            return [];
        }

        $shippingIds = $productVariants
            ->pluck('product.shipping_ids')
            ->filter()
            ->unique()
            ->flatten()
            ->values()
            ->toArray();

        if (empty($shippingIds)) {
            return [];
        }

        $shippingMethods = $this->shippingMethodRepository->findByWhere(
            ['publish' => 1],
            ['*'],
            [],
            true,
            [],
            [
                'field' => 'id',
                'value' => $shippingIds
            ]
        );

        return $shippingMethods;
    }
}
