<?php

// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.

namespace App\Services\Product;

use App\Repositories\Interfaces\Product\ProductRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

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

        $select = ['id', 'name', 'brand_id', 'supplier_id', 'product_catalogue_id', 'sku', 'image', 'publish', 'product_type'];
        $orderBy = ['id' => 'desc'];
        $relations = ['variants', 'warehouses', 'catalogue', 'brand', 'supplier'];

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

            $this->createProductVariant($product, $payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }

    private function preparePayload(): array
    {
        $payload = request()->except('_token', '_method');
        $payload['allow_sell'] = filter_var($payload['allow_sell'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $payload['is_taxable'] = filter_var($payload['is_taxable'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $payload['sku'] = generateSKU($payload['name']);

        if ($payload['is_taxable']) {
            $tax = $payload['tax'] ?? null;

            if ($tax) {
                $payload['tax_status'] = $tax['tax_status'] ?? null;

                if ($tax['tax_status'] == '2') {
                    $payload['input_tax_id'] = $tax['input_tax'] ?? null;
                    $payload['output_tax_id'] = $tax['output_tax'] ?? null;
                }
            }
        }

        return $payload;
    }

    private function createProductVariant($product, array $payload)
    {
        $canonical = Str::slug($payload['name']);
        $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $product->id.','.$canonical);
        $is_discount_time = filter_var($payload['is_discount_time'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $sale_price_start_at = $payload['sale_price_time'][0] ?? null;
        $sale_price_end_at = $payload['sale_price_time'][1] ?? null;

        $mainData = [
            'name' => $payload['name'] ?? null,
            'uuid' => $uuid,
            'canonical' => $canonical,
            'image' => $payload['image'] ?? null,
            'album' => $payload['album'] ?? null,
            'price' => $payload['price'] ?? null,
            'sale_price' => $payload['sale_price'] ?? null,
            'import_price' => $payload['import_price'] ?? null,
            'is_discount_time' => $is_discount_time,
            'weight' => $payload['weight'] ?? null,
            'length' => $payload['length'] ?? null,
            'width' => $payload['width'] ?? null,
            'height' => $payload['height'] ?? null,
            'sku' => generateSKU($payload['name'], 3, ['default']),
            'sale_price_start_at' => $sale_price_start_at ? convertToYyyyMmDdHhMmSs($sale_price_start_at) : null,
            'sale_price_end_at' => $sale_price_end_at ? convertToYyyyMmDdHhMmSs($sale_price_end_at) : null,
        ];

        $product->variants()->create($mainData);

        if ($payload['product_type'] === 'variable') {
            $this->createVariableProductVariants($product, $payload, $mainData);
        }
    }

    private function createVariableProductVariants($product, array $payload, array $mainData)
    {
        $variable = $payload['variable'] ?? [];
        $variantTexts = json_decode($payload['variants'] ?? '[]', true);
        $attributeIds = removeEmptyValues(json_decode($payload['attributes'] ?? '[]', true))['attrIds'];

        $productVariantPayload = collect($variable['count'] ?? [])
            ->map(function ($count, $key) use ($mainData, $variable, $variantTexts) {
                $options = explode('-', $variantTexts[$key] ?? '');
                $sku = generateSKU($mainData['name'], 3, $options);
                $name = "{$mainData['name']} {$variantTexts[$key]}";

                $variantData = [
                    'name' => $name,
                    'uuid' => Uuid::uuid5(Uuid::NAMESPACE_DNS, $sku),
                    'canonical' => Str::slug($name),
                    'image' => $variable['image'][$key] ?? $mainData['image'],
                    'album' => $variable['album'][$key] ?? $mainData['album'],
                    'price' => $variable['price'][$key] ?? $mainData['price'],
                    'sale_price' => $variable['sale_price'][$key] ?? null,
                    'import_price' => $variable['import_price'][$key] ?? $mainData['import_price'],
                    'is_discount_time' => filter_var($variable['is_discount_time'][$key] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'width' => $variable['width'][$key] ?? $mainData['width'],
                    'height' => $variable['height'][$key] ?? $mainData['height'],
                    'length' => $variable['length'][$key] ?? $mainData['length'],
                    'weight' => $variable['weight'][$key] ?? $mainData['weight'],
                    'sku' => $sku,
                    'sale_price_start_at' => isset($variable['sale_price_time'][$key][0]) ? convertToYyyyMmDdHhMmSs($variable['sale_price_time'][$key][0]) : null,
                    'sale_price_end_at' => isset($variable['sale_price_time'][$key][1]) ? convertToYyyyMmDdHhMmSs($variable['sale_price_time'][$key][1]) : null,
                ];

                return $variantData;
            })
            ->values()
            ->toArray();

        $createdVariants = $product->variants()->createMany($productVariantPayload);

        $attributeCombines = $this->combineAttribute(array_values($attributeIds));
        $variantAttributePayload = $createdVariants->flatMap(function ($variant, $index) use ($attributeCombines) {
            return collect($attributeCombines[$index])->map(function ($attributeId) use ($variant) {
                return [
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attributeId,
                ];
            });
        })->values()->all();

        DB::table('product_variant_attribute')->insert($variantAttributePayload);
    }

    private function combineAttribute($attributeIds)
    {
        if (! count($attributeIds)) {
            return [];
        }

        return array_reduce($attributeIds, function ($acc, $attr) {
            return $acc ? array_merge(...array_map(function ($x) use ($attr) {
                return array_map(function ($y) use ($x) {
                    return array_merge(is_array($x) ? $x : [$x], [$y]);
                }, $attr);
            }, $acc)) : $attr;
        }, []);
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
