<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'                => 'required|email',
            'fullname'             => 'required',
            'password'             => 'required',
            'g-recaptcha-response' => 'required',

        ];
    }

    public function attributes()
    {
        return [
            'email'                => 'Email',
            'fullname'             => 'Họ và tên',
            'password'             => 'Mật khẩu',
            'g-recaptcha-response' => 'Xác minh captcha',

        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
