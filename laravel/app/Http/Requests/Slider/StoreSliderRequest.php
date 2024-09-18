<?php

namespace App\Http\Requests\Slider;


use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
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
            'code' => 'required|unique:sliders',
            'items.*' => 'required',
            'items.*.image' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.url' => 'required|string',
            'items.*.alt' => 'required|string',
            'setting' => 'required',
            'setting.width' => 'required|integer',
            'setting.height' => 'required|integer',
            'setting.navigate' => 'required',
            'setting.animation' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên trình chiếu',
            'code' => 'Mã trình chiếu',
            'items' => 'Hình ảnh trình chiếu',
            'setting' => 'Cài đặt trình chiếu',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
