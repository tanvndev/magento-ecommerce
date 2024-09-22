<?php



namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class TestController extends Controller
{
    // public function index()
    // {

    //     $product = Product::query()
    //         ->with([
    //             'variants.attribute_values',
    //             // 'attributes' => function ($query) {
    //             //     $query->with(['attribute' => function ($queryAttribute) {
    //             //         $queryAttribute->select(['id', 'name'])
    //             //             ->with('attribute_values');
    //             //     }]);
    //             // }
    //         ])
    //         ->find(19);
    //     dd($product->toArray());

    //     $product->attributes->transform(function ($productAttribute) {
    //         $attribute = $productAttribute->attribute;
    //         $attributeValueIds = $productAttribute->attribute_value_ids;

    //         $filteredValues = $attribute->attribute_values->filter(function ($item) use ($attributeValueIds) {
    //             return in_array($item->id, $attributeValueIds);
    //         });

    //         $attribute->makeHidden('attribute_values');
    //         $attribute->values = $filteredValues;

    //         $productAttribute->attribute = $attribute;

    //         return $productAttribute;
    //     });

    //     dd($product->toArray());

    //     return response()->json($product);

    //     return view('test');
    // }

    public function getAllCart()
    {
        if (auth()->check()) {
            // $userId = auth()->user()->id;
            // $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);
            // return response()->json($cart);
        }

        return response()->json(Cart::content());
    }

    public function createOrUpdateCart(Request $request)
    {
        if (auth()->check()) {
            // $userId = auth()->user()->id;
            // $cart = $this->cartRepository->findByWhere(["user_id" => $userId]);
            // return response()->json($cart);
        }

        return response()->json(Cart::content());
    }
}
