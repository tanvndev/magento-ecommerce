<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Enums\ResponseEnum;

class StoreWarehouseRequest extends FormRequest
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
            'name' => 'required|string',
            'code' => 'unique:warehouses,code',
            'phone' => 'required|regex:/^0[0-9]{9}$/',
            'address' => 'required|string',
            'supervisor_name' => 'required|string',
        ];

        if (!$this->has('warehouse_configurations') || !$this->get('warehouse_configurations')) {
            $rules = array_merge($rules, [
                'aisles_number' => 'required|integer|min:1',
                'racks_number' => 'required|integer|min:1',
                'shelves_number' => 'required|integer|min:1',
                'compartments_number' => 'required|integer|min:1',
            ]);
        }

        return $rules;
    }


    public function attributes()
    {
        return [
            'name' => 'Tên kho hàng',
            'code' => 'Mã kho hàng',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ kho hàng',
            'supervisor_name' => 'Tên người quản lý',
            'aisles_number' => 'Số dãy',
            'racks_number' => 'Số kệ',
            'shelves_number' => 'Số tầng',
            'compartments_number' => 'Số khoang',
        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'phone.regex' => 'Số điện thoại không đúng dạng.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'messages' => $validator->errors(),
        ], ResponseEnum::UNPROCESSABLE_ENTITY));
    }
}
