<?php

namespace App\Http\Requests\Warehouse;

use App\Enums\ResponseEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWarehouseRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required|unique:warehouses,code,' . $this->warehouse,
            'phone' => 'required|regex:/^0[0-9]{9}$/',
            'address' => 'required',
            'shelve' => 'required',
            'row' => 'required',
            'supervisor_name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên kho hàng',
            'code' => 'Mã kho hàng',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ kho hàng',
            'shelve' => 'Số kệ kho hàng',
            'row' => 'Số hàng',
            'supervisor_name' => 'Tên người quản lý',
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
