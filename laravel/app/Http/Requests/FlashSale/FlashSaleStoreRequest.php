<?php

namespace App\Http\Requests\FlashSale;

use Illuminate\Foundation\Http\FormRequest;

class FlashSaleStoreRequest extends FormRequest
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

        return [
            'name' => 'required|string|max:255|unique:flash_sales',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_at',
            'max_quantities' => 'required|array',
            'max_quantities.*' => 'required|integer|min:1',
            'sale_prices' => 'required|array',
            'sale_prices.*' => 'required|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'max_quantity.*' => 'số lượng tối đa',
            'sale_price.*' => 'giá khuyến mãi',
            'name' => 'tên khuyến mãi',
            'start_date' => 'bắt đầu khuyến mãi',
            'end_date' => 'kết thúc khuyến mãi',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
