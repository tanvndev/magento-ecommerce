<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
        $rules = [];

        if ($this->has('fullname')) {
            $rules['fullname'] = 'required|string';
        }

        if ($this->has('email')) {
            $rules['email'] = 'required|string|email|unique:users,email,' . $this->id;
        }

        if ($this->has('phone')) {
            $rules['phone'] = 'required|regex:/(0)[0-9]{9}/|unique:users,phone,' . $this->id;
        }

        if ($this->has('birthday')) {
            $rules['birthday'] = 'required|date' . $this->id;
        }


        return $rules;
    }

    public function attributes()
    {
        return [
            'fullname'         => 'Họ và tên',
            'province_id'      => 'Tỉnh/ Thành phố',
            'district_id'      => 'Quận/ Huyện',
            'ward_id'          => 'Phường/ Xã',
            'shipping_address' => 'Địa chỉ giao hàng',
            'phone'            => 'Số điện thoại',
            'is_primary'       => 'Mặc định',
        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'phone.regex' => 'Số điện thoại không đúng dạng.',
        ];
    }
}
