<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Product;

use App\Repositories\Interfaces\Product\ProductRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Product\ProductServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            'searchFields' => ['fullname', 'email', 'phone', 'address'],
            'publish' => request('publish'),
        ];

        $data = $this->productRepository->pagination(
            ['id', 'fullname', 'email', 'phone', 'address', 'publish'],
            $condition,
            request('pageSize'),
            ['id' => 'desc'],
        );

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = $this->preparePayload();
            $product = $this->productRepository->create($payload);

            if ($payload['product_type'] == 'variable') {
                $productVariantIds = $this->createProductVariant($product, $payload);

                if (count($productVariantIds)) {
                    $this->createProductVariantWarehouse($payload['stock'], $product, $productVariantIds);
                }
            } elseif ($payload['product_type'] == 'simple') {
                $this->createProductWarehouse($product, $payload);
            }

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
        $mainData = [
            'name' => $payload['name'] ?? null,
            'image' => $payload['image'] ?? null,
            'album' => $payload['album'] ?? null,
            'price' => $payload['price'] ?? null,
            'import_price' => $payload['import_price'] ?? null,
            'weight' => $payload['weight'] ?? null,
            'length' => $payload['length'] ?? null,
            'width' => $payload['width'] ?? null,
            'height' => $payload['height'] ?? null,
        ];
        $variable = $payload['variable'] ?? [];
        $variantTexts =  json_decode($payload['variants'] ?? '[]', true);
        $attributesArray = json_decode($payload['attributes'] ?? '[]', true);
        $attributeIds = removeEmptyValues($attributesArray)['attrIds'];

        $productVariantPayload = collect($variable['count'] ?? [])
            ->map(function ($count, $key) use ($mainData, $variable, $variantTexts, $product) {
                $options = explode('-', $variantTexts[$key] ?? '');
                $sku = generateSKU($mainData['name'], 3, $options);

                $variantData = [
                    'name' => "{$mainData['name']} {$variantTexts[$key]}",
                    'uuid' => Uuid::uuid5(Uuid::NAMESPACE_DNS, $product->id . $sku),
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
                ];

                if ($variantData['is_discount_time']) {
                    $salePriceTime = $variable['sale_price_time'][$key] ?? [];
                    $variantData['sale_price_start_at'] = !empty($salePriceTime[0]) ? convertToYyyyMmDdHhMmSs($salePriceTime[0]) : null;
                    $variantData['sale_price_end_at'] = !empty($salePriceTime[1]) ? convertToYyyyMmDdHhMmSs($salePriceTime[1]) : null;
                }

                return $variantData;
            })
            ->values()
            ->toArray();

        $createdVariants = $product->variants()->createMany($productVariantPayload);
        $productVariantIds = $createdVariants->pluck('id')->toArray();
        $attributeCombines = $this->combineAttribute(array_values($attributeIds));

        $variantAttributePayload = $createdVariants->flatMap(function ($variant, $index) use ($attributeCombines) {
            return collect($attributeCombines[$index])->map(function ($attributeId) use ($variant) {
                return [
                    'product_variant_id' => $variant->id,
                    'attribute_id' => $attributeId,
                ];
            });
        })
            ->values()
            ->all();

        DB::table('product_variant_attribute')->insert($variantAttributePayload);
        return $productVariantIds;
    }


    private function combineAttribute($attributeIds)
    {
        if (!count($attributeIds)) {
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


    private function createProductWarehouse($product, array $payload)
    {
        $stock = $payload['stock'] ?? [];
        $data = [];
        if (count($stock)) {
            foreach ($stock['in_stock'] as $key => $inStock) {
                $data[] = [
                    'warehouse_id' => $key,
                    'in_stock' => $inStock[0] ?? 0,
                    'cog_price' => $stock['cog_price'][$key][0] ?? 0,
                    'type' => 'initial',
                ];
            }
        }
        $product->warehouses()->sync($data);
    }

    private function createProductVariantWarehouse(array $stocks, $product, array $productVariantIds)
    {
        $data = [];
        foreach ($productVariantIds as $key => $productVariantId) {
            foreach ($stocks['in_stock'] as $keyStock => $stock) {
                $data[] = [
                    'product_variant_id' => $productVariantId,
                    'warehouse_id' => $keyStock,
                    'in_stock' => $stock[$key] ?? 0,
                    'cog_price' => $stocks['cog_price'][$keyStock][$key] ?? 0,
                    'type' => 'initial',
                ];
            }
        }

        $product->warehouses()->sync($data);
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
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Xóa thất bại.',
                'data' => null
            ];
        }
    }
}
