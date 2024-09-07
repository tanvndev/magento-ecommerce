<?php

namespace App\Http\Requests\Attribute;

use App\Enums\ResponseEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAttributeRequest extends FormRequest
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
            'code' => 'required|unique:attributes,code,' . $this->attribute,
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thuộc tính',
            'code' => 'Mã thuộc tính',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
