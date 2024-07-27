<?php

namespace App\Http\Requests\Supplier;

use App\Enums\ResponseEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSupplierRequest extends FormRequest
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
            'company_name' => 'required',
            'contact_name' => 'required',
            'contact_email' => 'required|email|unique:suppliers,contact_email,' . $this->supplier,
            'contact_phone' => 'required|regex:/(0)[0-9]{9}/|unique:suppliers,contact_phone,' . $this->supplier,
            'address' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'company_name' => 'Tên công ty',
            'contact_name' => 'Tên người cung cấp',
            'contact_email' => 'Email',
            'contact_phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'messages' => $validator->errors(),
        ], ResponseEnum::UNPROCESSABLE_ENTITY));
    }
}
