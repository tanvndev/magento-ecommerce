<?php

namespace App\Http\Requests\Slider;

use App\Enums\ResponseEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateSliderRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'sub_title' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'description' => ['required', 'string'],
            'button_link' => ['nullable'],
            'status' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'title'         => 'Tiểu đề Slider',
            'sub_title'     => 'Tiêu đề phụ',
            'image'         => 'Hình ảnh',
            'description'   => 'Nội dung',
            'button_link'   => 'Link',
            'status'        => 'Trạng thái',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'messages' => $validator->errors(),
        ], ResponseEnum::UNPROCESSABLE_ENTITY));
    }
}
