<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserCatalogueRequest extends FormRequest
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
            'code' => 'required',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên nhóm thành viên',
            'code' => 'Mã nhóm này',
            'description' => 'Mô tả nhóm thành viên',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
