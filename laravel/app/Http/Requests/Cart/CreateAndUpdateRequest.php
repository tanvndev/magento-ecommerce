<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CreateAndUpdateRequest extends FormRequest
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
            'product_variant_id' => 'required'
        ];

        if (request()->has('quantity')) {
            $rules['quantity'] = 'required|integer|min:1';
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'product_variant_id' => 'Sản phẩm',
            'quantity' => 'Số lượng',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
