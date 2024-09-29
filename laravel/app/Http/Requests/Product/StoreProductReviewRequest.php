<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductReviewRequest extends FormRequest
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
        $isCatalogueUser = request()->user()->user_catalogue_id === 1;

        return [
            'rating' => $isCatalogueUser ? 'nullable' : 'required|integer|min:1|max:5',
            'comment' => $isCatalogueUser ? 'required' : 'nullable',
        ];
    }


    public function attributes(): array
    {
        return [
            'rating' => 'Đánh giá',
            'comment' => 'Phản hồi',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
