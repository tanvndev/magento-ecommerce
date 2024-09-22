<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CreateAndUpdateRequest extends FormRequest
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
        $rules = [];

        if (request()->quantity) {
            $rules['quantity'] = 'integer|min:1';
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'quantity' => 'Số lượng',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
