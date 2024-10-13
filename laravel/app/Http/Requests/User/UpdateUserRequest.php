<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email'             => 'required|string|email|unique:users,email,' . $this->user,
            'phone'             => 'required|regex:/(0)[0-9]{9}/|unique:users,phone,' . $this->user,
            'fullname'          => 'required|string',
            'user_catalogue_id' => 'required|integer|gt:0',
        ];
    }

    public function attributes()
    {
        return [
            'email'             => 'Email',
            'fullname'          => 'Họ tên thành viên',
            'phone'             => 'Số điện thoại',
            'user_catalogue_id' => 'Nhóm thành viên',

        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'phone.regex' => 'Số điện thoại không đúng dạng.',
        ];
    }
}
