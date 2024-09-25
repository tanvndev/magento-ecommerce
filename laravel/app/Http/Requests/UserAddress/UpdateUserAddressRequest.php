<?php

namespace App\Http\Requests\UserAddress;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAddressRequest extends FormRequest
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
            'fullname' => 'required|string|max:255',
            'province_code' => 'required|exists:provinces,code',
            'district_code' => 'required|exists:districts,code',
            'ward_code' => 'required|exists:wards,code',
            'shipping_address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ];
    }

    public function attributes()
    {
        return [
            'fullname' => 'Họ và tên',
            'province_code' => 'Tỉnh / Thành phố',
            'district_code' => 'Quận / Huyện',
            'ward_code' => 'Phường / Xã',
            'shipping_address' => 'Địa chỉ giao hàng',
            'phone' => 'Số điện thoại',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
