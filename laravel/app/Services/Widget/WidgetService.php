<?php



// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Widget;

use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Repositories\Interfaces\Widget\WidgetRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Widget\WidgetServiceInterface;

class WidgetService extends BaseService implements WidgetServiceInterface
{
    protected $widgetRepository;

    protected $productVariantRepository;

    public function __construct(
        WidgetRepositoryInterface $widgetRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->widgetRepository = $widgetRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function paginate()
    {
        $request = request();

        $condition = [
            'search'  => addslashes($request->search),
            'publish' => $request->publish,
            'archive' => $request->boolean('archive'),
        ];

        $select = ['id', 'name', 'publish', 'description', 'code', 'advertisement_banners', 'type', 'order', 'model_ids'];
        $pageSize = $request->pageSize;

        $data = $pageSize && $request->page
            ? $this->widgetRepository->pagination($select, $condition, $pageSize, ['order' => 'ASC'])
            : $this->widgetRepository->findByWhere(['publish' => 1], $select, [], true);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = $this->preparePayload();
            $this->widgetRepository->create($payload);

            return successResponse(__('messages.create.success'));
        }, __('messages.create.error'));
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $payload = $this->preparePayload();
            $this->widgetRepository->update($id, $payload);

            return successResponse(__('messages.update.success'));
        }, __('messages.update.error'));
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');

        $payload['model_ids'] = array_map('intval', $payload['model_ids'] ?? []);

        if ($payload['type'] == 'advertisement' && isset($payload['image']) && ! empty($payload['image'])) {
            $payload['advertisement_banners'] = array_map(fn ($image, $key) => [
                'image' => $image,
                'alt' => $payload['alt'][$key] ?? '',
                'content' => $payload['content'][$key] ?? '',
                'url'     => $payload['url'][$key] ?? '',
            ], $payload['image'], array_keys($payload['image']));
        }

        return $payload;
    }

    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->widgetRepository->delete($id);

            return successResponse(__('messages.delete.success'));
        }, __('messages.delete.error'));
    }

    // CLIENT API //

    public function getWidgetByCode(string $code)
    {
        $widgets = $this->widgetRepository->findByWhere(
            [
                'code'    => $code,
                'publish' => 1,
            ],
            ['id', 'name', 'code', 'order', 'model_ids', 'advertisement_banners', 'type'],
            [],
            true,
            ['order' => 'ASC']
        );

        // Process each widget based on its type and model
        $widgets->transform(function ($item) {
            // Match same switch-case
            $item->items =
                match ($item->type) {
                    'advertisement' => $item->advertisement_banners,
                    'product'       => $this->getProductVariants($item),
                    default         => [],
                };

            return $item;
        });

        return $widgets;
    }

    private function getProductVariants($item)
    {
        return $this->productVariantRepository->findByWhereIn(
            $item->model_ids, // -> value
            'id', // -> field
            ['*'],
            [], // -> relation
            [
                'product' => [
                    ['publish', '1'],
                ],
            ] // -> whereHas
        ) ?? [];
    }

    public function getAllWidgetCode()
    {
        return $this->widgetRepository->findByWhere(
            [
                'publish' => 1,
            ],
            ['id', 'code', 'order'],
            [],
            true,
            ['order' => 'ASC']
        );
    }
}
