<?php

namespace App\Http\Requests\ShippingMethod;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippingMethodRequest extends FormRequest
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
            'name' => 'string|required',
            'code' => 'string|unique',
            'base_cost' => 'required|numeric',
            'image' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên phương thức vận chuyển',
            'code' => 'Mã phương thức vận chuyển',
            'image' => 'Ảnh phương thức vận chuyển',
            'base_cost' => 'Giá cố định của phương thức vận chuyển',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
