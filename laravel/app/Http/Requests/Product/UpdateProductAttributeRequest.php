<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductAttributeRequest extends FormRequest
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
            'attribute_attribute_value_ids' => ['required', function ($attribute, $value, $fail) {
                if (! is_array($value)) {
                    return $fail('Giá trị thuộc tính phải là mảng.');
                }

                if (count($value) > 3) {
                    return $fail('Số lượng thuộc tính không được vượt quá 3.');
                }

                foreach ($value as $key => $values) {
                    if (! is_array($values) || empty($values)) {
                        return $fail('Không được để trống giá trị.');
                    }

                    foreach ($values as $val) {
                        if (empty($val)) {
                            return $fail('Không được để trống giá trị.');
                        }
                    }
                }
            }],
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'attribute_attribute_value_ids' => 'Giá trị thuộc tính',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
