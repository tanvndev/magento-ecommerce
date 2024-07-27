<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Enums\ResponseEnum;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|unique:users|regex:/(0)[0-9]{9}/',
            'fullname' => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
            'password' => 'required|string|min:6',

        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'fullname' => 'Họ tên thành viên',
            'phone' => 'Số điện thoại',
            'user_catalogue_id' => 'Nhóm thành viên',
            'password' => 'Mật khẩu',

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
