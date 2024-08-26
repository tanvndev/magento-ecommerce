<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Product;

use App\Repositories\Interfaces\Product\ProductRepositoryInterface;
use App\Repositories\Interfaces\Product\ProductVariantRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductServiceInterface;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ProductService extends BaseService implements ProductServiceInterface
{
    protected $productRepository;
    protected $productVariantRepository;


    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];

        $select = ['id', 'name', 'brand_id', 'publish', 'product_type', 'quantity', 'enable_manage_stock', 'stock_status'];
        $orderBy = ['id' => 'desc'];
        $relations = ['variants', 'catalogues', 'brand'];

        $data = $this->productRepository->pagination(
            $select,
            $condition,
            request('pageSize'),
            $orderBy,
            [],
            $relations
        );

        return $data;
    }

    public function getProductVariants()
    {
        $condition = [
            'search' => addslashes(request('search')),
        ];

        $select = ['id', 'name', 'product_id', 'price', 'cost_price', 'sale_price', 'image', 'attribute_value_combine'];
        $orderBy = ['id' => 'desc'];
        $relations = ['attribute_values'];

        $data = $this->productVariantRepository->pagination(
            $select,
            $condition,
            request('pageSize', 20),
            $orderBy,
            [],
            $relations
        );

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = $this->preparePayload();
            $product = $this->productRepository->create($payload);
            $this->syncCatalogue($product, $payload['product_catalogue_id']);
            $this->createProductAttribute($product, $payload);
            $this->createProductVariant($product, $payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    public function syncCatalogue($product, array $catalogueIds): void
    {
        $product->catalogues()->sync($catalogueIds);
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        $payload['sku'] = generateSKU($payload['name']);
        $payload['enable_manage_stock'] =
            (!isset($payload['enable_manage_stock']) || $payload['enable_manage_stock'] == false) ?
            false : $payload['enable_manage_stock'];

        $payload['enable_manage_stock'] = filter_var($payload['enable_manage_stock'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $payload = $this->createSEO($payload, 'name', 'excerpt');

        return $payload;
    }


    private function createProductVariant($product, array $payload)
    {
        $is_discount_time = filter_var($payload['is_discount_time'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $sale_price_start_at = $payload['sale_price_time'][0] ?? null;
        $sale_price_end_at = $payload['sale_price_time'][1] ?? null;
        $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $product->id . ', ' . 'default');

        $mainData = [
            'uuid' => $uuid,
            'name' => $payload['name'] ?? null,
            'image' => $payload['image'] ?? null,
            'album' => $payload['album'] ?? null,
            'price' => $payload['price'] ?? null,
            'sale_price' => $payload['sale_price'] ?? null,
            'cost_price' => $payload['cost_price'] ?? null,
            'is_discount_time' => $is_discount_time,
            'weight' => $payload['weight'] ?? null,
            'length' => $payload['length'] ?? null,
            'width' => $payload['width'] ?? null,
            'height' => $payload['height'] ?? null,
            'stock' => $payload['stock'] ?? 0,
            'low_stock_amount' => $payload['low_stock_amount'] ?? 0,
            'sku' => generateSKU($payload['name'], 3, ['default']),
            'sale_price_start_at' => $sale_price_start_at ? convertToYyyyMmDdHhMmSs($sale_price_start_at) : null,
            'sale_price_end_at' => $sale_price_end_at ? convertToYyyyMmDdHhMmSs($sale_price_end_at) : null,
        ];


        if ($payload['product_type'] === 'simple') {
            return $product->variants()->create($mainData);
        }

        if ($payload['product_type'] === 'variable') {
            return $this->createProductVariants($product, $payload, $mainData);
        }
    }



    private function createProductVariants($product, array $payload, array $mainData)
    {
        $variables = $payload['variable'] ?? [];
        $variants = json_decode($payload['variants'] ?? '[]', true);
        $variantTexts = $variants['variantTexts'];
        $variantIds = $variants['variantIds'];
        $attributes = removeEmptyValues(json_decode($payload['attributes'] ?? '[]', true));
        $attributeIds = $attributes['attrIds'];
        $attributeIdEnableVariation = $this->formatAttributeEnableVariation($attributeIds, $attributes['enable_variation'] ?? []);

        if (empty($attributeIdEnableVariation)) {
            return false;
        }

        $productVariantPayload = collect($variables ?? [])
            ->map(function ($variable, $key) use ($mainData, $variantTexts, $variantIds, $product) {

                $options = explode('-', $variantTexts[$key] ?? '');
                $sku = generateSKU($mainData['name'], 3, $options) . '-' . ($key + 1);
                $name = "{$mainData['name']} {$variantTexts[$key]}";
                $attribute_value_combine = sortString($variantIds[$key]);
                $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $product->id . ', ' . $attribute_value_combine);

                $variantData = [
                    'uuid' => $uuid,
                    'name' => $name,
                    'attribute_value_combine' => $attribute_value_combine,
                    'image' => $variable['image'] ?? $mainData['image'],
                    'album' => $variable['album'] ?? $mainData['album'],
                    'price' => $variable['price'] ?? $mainData['price'],
                    'sale_price' => $variable['sale_price'] ?? null,
                    'cost_price' => $variable['cost_price'] ?? $mainData['cost_price'],
                    'is_discount_time' => filter_var($variable['is_discount_time'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'width' => $variable['width'] ?? $mainData['width'],
                    'height' => $variable['height'] ?? $mainData['height'],
                    'length' => $variable['length'] ?? $mainData['length'],
                    'weight' => $variable['weight'] ?? $mainData['weight'],
                    'sku' => $sku,
                    'stock' => $variable['stock'] ?? 0,
                    'low_stock_amount' => $variable['low_stock_amount'] ?? 0,
                    'sale_price_start_at' => isset($variable['sale_price_time'][0]) ? convertToYyyyMmDdHhMmSs($variable['sale_price_time'][0]) : null,
                    'sale_price_end_at' => isset($variable['sale_price_time'][1]) ? convertToYyyyMmDdHhMmSs($variable['sale_price_time'][1]) : null,
                ];

                return $variantData;
            })
            ->values()
            ->toArray();

        $createdVariants = $product->variants()->createMany($productVariantPayload);
        $variantAttributePayload = $this->combineAttribute($createdVariants);

        DB::table('product_variant_attribute_value')->insert($variantAttributePayload);
    }

    private function createProductAttribute($product, array $payload)
    {
        if (!isset($payload['attributes']) || empty($payload['attributes'])) {
            return false;
        }

        $attributes = removeEmptyValues(json_decode($payload['attributes'] ?? '[]', true));

        $attributePayload = [];

        foreach ($attributes['attrIds'] as $attrId => $attrValueIds) {
            $attributePayload[] = [
                'attribute_id' => $attrId,
                'attribute_value_ids' => $attrValueIds,
                'enable_variation' => $attributes['enable_variation'][$attrId] ?? false,
            ];
        }

        $product->attributes()->createMany($attributePayload);

        return true;
    }

    private function formatAttributeEnableVariation(array $attributeIds, array $enableVariantion, bool $enable = true): array
    {
        $attrIds = [];
        foreach ($enableVariantion as $key => $value) {
            if ($enable == true && $value == true) {
                $attrIds[$key] = $attributeIds[$key];
            } elseif ($enable == false && $value == true) {
                unset($attributeIds[$key]);
            }
        }
        return $enable ? $attrIds : $attributeIds;
    }

    private function combineAttribute($productVariants)
    {
        if (!count($productVariants)) {
            return [];
        }

        $result = $productVariants->flatMap(function ($item) {
            $attributeValueIds = explode(',', $item['attribute_value_combine']);
            return collect($attributeValueIds)->map(function ($value) use ($item) {
                return [
                    'attribute_value_id' => $value,
                    'product_variant_id' => $item['id']
                ];
            });
        });


        return $result->toArray();
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $payload = request()->except('_token', '_method');

            $this->productRepository->update($id, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Xoá mềm
            $this->productRepository->delete($id);
            DB::commit();

            return [
                'status' => 'success',
                'messages' => 'Xóa thành công.',
                'data' => null,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'error',
                'messages' => 'Xóa thất bại.',
                'data' => null,
            ];
        }
    }
}
