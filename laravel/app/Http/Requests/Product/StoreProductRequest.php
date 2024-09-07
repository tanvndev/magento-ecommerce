<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'string|required',
            'image' => 'string|required',
            'album' => 'string|required',
            'product_catalogue_id' => 'required',
            'product_type' => 'required',
            'cost_price' => 'required|numeric',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric|lt:price',
        ];

        if ($this->product_type == 'variable') {
            $rules['variants'] = 'required';

            foreach ($this->variable as $key => $item) {
                $price = $item['price'] ?? null;
                $sale_price = $item['sale_price'] ?? null;
                if ($price && $sale_price) {
                    $rules['variable.'.$key.'.sale_price'] = 'numeric|lt:variable.'.$key.'.price';
                }
            }
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tiêu đề sản phẩm',
            'image' => 'Ảnh sản phẩm',
            'album' => 'Thư viện ảnh',
            'product_type' => 'Loại sản phẩm',
            'product_catalogue_id' => 'Nhóm sản phẩm',
            'cost_price' => 'Giá nhập',
            'price' => 'Giá bán',
            'sale_price' => 'Giá khuyến mãi',
            'variable.*.sale_price' => 'Giá khuyến mãi biến thể',
            'variable.*.price' => 'Giá gốc biến thể',
        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'variable.*.sale_price.lt' => 'Giá khuyến mãi biến thể phải nhỏ hơn giá bán biến thể.',
        ];
    }
}
