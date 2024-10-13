<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginOtpRequest extends FormRequest
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
            'phone'             => 'required|regex:/(0)[0-9]{9}/',
            'verification_code'               => 'required',
            'g-recaptcha-response' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'phone'             => 'Số điện thoại',
            'verification_code'               => 'Mã xác nhận',
            'g-recaptcha-response' => 'Xác minh captcha',
        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'phone.regex' => 'Số điện thoại không đúng dạng.',
        ];
    }
}
