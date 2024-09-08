<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeValueRequest extends FormRequest
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
            'attribute_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên giá trị thuộc tính',
            'attribute_id' => 'Thuộc tính',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
