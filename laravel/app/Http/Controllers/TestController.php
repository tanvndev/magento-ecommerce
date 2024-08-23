<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {

        $product = Product::query()
            ->with([
                'variants',
                'attributes' => function ($query) {
                    $query->with(['attribute' => function ($queryAttribute) {
                        $queryAttribute->select(['id', 'name'])
                            ->with('attribute_values');
                    }]);
                }
            ])
            ->find(7);

        $product->attributes->transform(function ($productAttribute) {
            $attribute = $productAttribute->attribute;
            $attributeValueIds = $productAttribute->attribute_value_ids;

            $filteredValues = $attribute->attribute_values->filter(function ($item) use ($attributeValueIds) {
                return in_array($item->id, $attributeValueIds);
            });

            $attribute->makeHidden('attribute_values');
            $attribute->values = $filteredValues;

            $productAttribute->attribute = $attribute;

            return $productAttribute;
        });

        dd($product->toArray());
        return response()->json($product);


        return view('test');
    }
}
