<?php

namespace App\Http\Requests\User;

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
        if ($this->has('is_primary') && $this->is_primary) {
            return [
                'is_primary' => 'required',
            ];
        }

        $rules = [
            'fullname'         => 'required|string|max:255',
            'province_id'      => 'required',
            'district_id'      => 'required',
            'ward_id'          => 'required',
            'shipping_address' => 'required|string|max:255',
            'phone'            => 'required|regex:/(0)[0-9]{9}/',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'fullname'         => 'Họ và tên',
            'province_code'    => 'Tỉnh / Thành phố',
            'district_code'    => 'Quận / Huyện',
            'ward_code'        => 'Phường / Xã',
            'shipping_address' => 'Địa chỉ giao hàng',
            'phone'            => 'Số điện thoại',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
