<?php

namespace App\Http\Requests\Widget;

use Illuminate\Foundation\Http\FormRequest;

class StoreWidgetRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'type' => 'required',
            'canonical' => 'unique:brands',
        ];

        if ($this->type == 'product') {
            $rules['model_ids'] = 'required|array|min:8|max:50';
        }

        if ($this->type == 'advertisement') {
            $rules['image.*'] = 'required';
            $rules['url.*'] = 'required';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'image.*' => 'Hình ảnh',
            'url.*' => 'Đường dẫn',
            'name' => 'Tên thương hiệu',
            'type' => 'Loại widget',
            'canonical' => 'Đường dẫn',
            'model_ids' => 'Danh sách sản phẩm',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
