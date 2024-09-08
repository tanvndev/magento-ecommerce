<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
            'code' => 'string|unique,payment_methods,code,'.$this->payment_method,
            'image' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên phương thức thanh toán',
            'code' => 'Mã phương thức thanh toán',
            'image' => 'Ảnh phương thức thanh toán',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
