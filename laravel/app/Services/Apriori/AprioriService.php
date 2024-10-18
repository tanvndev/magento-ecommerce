<?php

namespace App\Services\Apriori;

use App\Models\Order;
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
            $filePath = 'orders.csv';
            $file = fopen($filePath, 'w');

            fputcsv($file, ['order_id', 'product_variant_ids']);

            Order::query()
                ->where('order_status', 'completed')
                ->where('payment_status', 'paid')
                ->where('delivery_status', 'delivered')
                ->with('order_items')
                ->chunk(1000, function ($orders) use ($file) {
                    foreach ($orders as $order) {
                        $product_variant_ids = implode(',', $order->order_items->pluck('product_variant_id')->toArray());
                        fputcsv($file, [$order->id, $product_variant_ids]);
                    }
                });

            fclose($file);
        } catch (\Exception $e) {
            // Ghi lại lỗi
            getError($e);
        }
    }


    public function getAprioriResultsFromRedis()
    {

        dd($this->suggestProducts(304));

        return $results;
    }

    public function suggestProducts($targetProductId, $topN = 5)
    {
        $aprioriResults = $this->getAprioriResults();
        $suggestions = [];

        foreach ($aprioriResults as $rule) {
            foreach ($rule['ordered_statistics'] as $stat) {
                $baseItems = $stat['items_base'];
                $addedItems = $stat['items_add'];

                if (in_array($targetProductId, $baseItems)) {
                    $this->addSuggestions($suggestions, $addedItems, $targetProductId, $stat);
                } elseif (in_array($targetProductId, $addedItems)) {
                    $this->addSuggestions($suggestions, $baseItems, $targetProductId, $stat);
                }
            }
        }

        // Sắp xếp các gợi ý theo confidence và lift
        usort($suggestions, function ($a, $b) {
            return ($b['confidence'] <=> $a['confidence']) ?: ($b['lift'] <=> $a['lift']);
        });

        // Loại bỏ các gợi ý trùng lặp, giữ lại gợi ý tốt nhất cho mỗi sản phẩm
        $uniqueSuggestions = [];
        foreach ($suggestions as $suggestion) {
            $productId = $suggestion['product_variant_id'];
            if (!isset($uniqueSuggestions[$productId]) || $suggestion['confidence'] > $uniqueSuggestions[$productId]['confidence']) {
                $uniqueSuggestions[$productId] = $suggestion;
            }
        }

        return array_slice(array_values($uniqueSuggestions), 0, $topN);
    }

    private function addSuggestions(&$suggestions, $items, $targetProductId, $stat)
    {
        foreach ($items as $item) {
            if ($item != $targetProductId) {
                $suggestions[] = [
                    'product_variant_id' => $item,
                    'confidence' => $stat['confidence'],
                    'lift' => $stat['lift']
                ];
            }
        }
    }

    private function getAprioriResults()
    {
        $results = Redis::lrange('apriori_suggest_product', 0, -1);
        return array_map(function ($result) {
            return json_decode($result, true);
        }, $results);
    }
}
