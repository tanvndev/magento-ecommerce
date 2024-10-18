<?php

namespace App\Services\Apriori;

use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use App\Services\Interfaces\Apriori\AprioriServiceInterface;
use Illuminate\Support\Facades\Redis;

class AprioriService implements AprioriServiceInterface
{

    public function __construct(
        protected OrderRepositoryInterface $orderRepository
    ) {}

    //     UPDATE orders
    // SET
    //     order_status = 'completed',
    //     payment_status = 'paid',
    //     delivery_status = 'delivered';



    public function exportOrdersToCsv()
    {
        try {
            $orders = $this->orderRepository->findByWhere(
                [
                    'order_status' => 'completed',
                    'payment_status' => 'paid',
                    'delivery_status' => 'delivered',
                ],
                ['id'],
                ['order_items'],
                true
            );

            $filePath = 'orders.csv';
            $file = fopen($filePath, 'w');

            fputcsv($file, ['order_id', 'product_variant_ids']); // Header CSV

            foreach ($orders as $order) {
                $product_variant_ids = implode(',', $order->order_items->pluck('product_variant_id')->toArray());
                fputcsv($file, [$order->id, $product_variant_ids]);
            }

            fclose($file);
        } catch (\Exception $e) {
            getError($e);
        }
    }

    public function getAprioriResultsFromRedis()
    {
        Redis::set('test_key', 'Hello, Redis!');
        $array = Redis::lrange('apriori_suggest_product', 0, -1);
        $results = [];

        foreach ($array as $key => $value) {
            $results[] = json_decode($value, true);
        }
        // dd($results);

        dd($this->getSuggestions($results, 408));

        return $results;
    }

    public function getSuggestions($suggestions, $productId)
    {
        $suggestedProducts = [];

        foreach ($suggestions as $suggestion) {
            if (in_array($productId, $suggestion['items'])) {
                foreach ($suggestion['ordered_statistics'] as $stat) {
                    $suggestedProducts = array_merge($suggestedProducts, $stat['items_add']);
                }
            }
        }

        // Loại bỏ sản phẩm hiện tại khỏi danh sách gợi ý
        $suggestedProducts = array_unique($suggestedProducts);
        $suggestedProducts = array_diff($suggestedProducts, [$productId]);

        return $suggestedProducts;
    }
}
