<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Product;

use App\Repositories\Interfaces\Product\ProductRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductServiceInterface;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
    ) {
        $this->productRepository = $productRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];

        $select = ['id', 'name', 'brand_id', 'product_catalogue_id', 'sku', 'image', 'publish', 'product_type'];
        $orderBy = ['id' => 'desc'];
        $relations = ['variants', 'catalogue', 'brand'];

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

        $mainData = [
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
            'enable_manage_stock' => $payload['enable_manage_stock'] ?? false,
            'stock_status' => $payload['stock_status'] ?? null,
            'quantity' => $payload['quantity'] ?? 0,
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

    private function createProductVariants($product, array $payload, array $mainData)
    {
        $variable = $payload['variable'] ?? [];
        $variants = json_decode($payload['variants'] ?? '[]', true);
        $variantTexts = $variants['variantTexts'];
        $variantIds = $variants['variantIds'];
        $attributes = removeEmptyValues(json_decode($payload['attributes'] ?? '[]', true));
        $attributeIds = $attributes['attrIds'];
        $attributeIdEnableVariation = $this->formatAttributeEnableVariation($attributeIds, $attributes['enable_variation'] ?? []);

        if (empty($attributeIdEnableVariation)) {
            return false;
        }

        $productVariantPayload = collect($variable['count'] ?? [])
            ->map(function ($count, $key) use ($mainData, $variable, $variantTexts, $variantIds) {
                $options = explode('-', $variantTexts[$key] ?? '');
                $sku = generateSKU($mainData['name'], 3, $options) . '-' . ($key + 1);
                $name = "{$mainData['name']} {$variantTexts[$key]}";
                $attribute_value_combine = sortString($variantIds[$key]);

                $variantData = [
                    'name' => $name,
                    'attribute_value_combine' => $attribute_value_combine,
                    'image' => $variable['image'][$key] ?? $mainData['image'],
                    'album' => $variable['album'][$key] ?? $mainData['album'],
                    'price' => $variable['price'][$key] ?? $mainData['price'],
                    'sale_price' => $variable['sale_price'][$key] ?? null,
                    'cost_price' => $variable['cost_price'][$key] ?? $mainData['cost_price'],
                    'is_discount_time' => filter_var($variable['is_discount_time'][$key] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'width' => $variable['width'][$key] ?? $mainData['width'],
                    'height' => $variable['height'][$key] ?? $mainData['height'],
                    'length' => $variable['length'][$key] ?? $mainData['length'],
                    'weight' => $variable['weight'][$key] ?? $mainData['weight'],
                    'sku' => $sku,
                    'enable_manage_stock' => filter_var($variable['enable_manage_stock'][$key] ?? false, FILTER_VALIDATE_BOOLEAN) ?? $mainData['enable_manage_stock'],
                    'stock_status' => $variable['stock_status'][$key] ?? $mainData['stock_status'],
                    'quantity' => $variable['quantity'][$key] ?? $mainData['quantity'],
                    'sale_price_start_at' => isset($variable['sale_price_time'][$key][0]) ? convertToYyyyMmDdHhMmSs($variable['sale_price_time'][$key][0]) : null,
                    'sale_price_end_at' => isset($variable['sale_price_time'][$key][1]) ? convertToYyyyMmDdHhMmSs($variable['sale_price_time'][$key][1]) : null,
                ];

                return $variantData;
            })
            ->values()
            ->toArray();

        $createdVariants = $product->variants()->createMany($productVariantPayload);
        $attributeCombines = $this->combineAttribute($attributeIdEnableVariation);

        $variantAttributePayload = $createdVariants->flatMap(function ($variant, $index) use ($attributeCombines) {
            return collect($attributeCombines[$index])->map(function ($attributeValueId, $attributeId) use ($variant) {
                return [
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attributeId,
                    'attribute_value_id' => $attributeValueId,
                ];
            });
        })->values()->all();

        DB::table('product_variant_attribute')->insert($variantAttributePayload);
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

    private function combineAttribute($attributeIds)
    {
        // dd($attributeIds);
        if (!count($attributeIds)) {
            return [];
        }

        $keys = array_keys($attributeIds);
        $values = array_values($attributeIds);

        $result = array_reduce($values, function ($acc, $attr) use ($keys) {
            if (empty($acc)) {
                return array_map(function ($item) use ($keys) {
                    return [$keys[0] => $item];
                }, $attr);
            }

            $newAcc = [];
            foreach ($acc as $existing) {
                foreach ($attr as $newItem) {
                    $newAcc[] = $existing + [end($keys) => $newItem];
                }
            }
            return $newAcc;
        }, []);

        return $result;
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
