<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
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
            'name' => 'required|max:255',
            'code' => 'required|max:50|unique:vouchers,code,'.$this->voucher,
            'description' => 'required|max:255',
            'image' => 'nullable',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'min_order_value' => 'nullable|integer',
            'min_quantity' => 'nullable|integer',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ];

        if ($this->min_order_value == null && $this->min_quantity == null) {
            $rules['min_order_value'] = 'required';
            $rules['min_quantity'] = 'required';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên mã giảm giá',
            'code' => 'Mã giảm giá',
            'image' => 'Hình ảnh mã giảm giá',
            'description' => 'Mô tả mã giảm giá',
            'discount_type' => 'Kiểu giá trị giảm giá',
            'discount_value' => 'Giá trị giảm giá',
            'quantity' => 'Số lượng mã giảm giá',
            'min_order_value' => 'Tổng giá trị đơn hàng tối thiểu',
            'min_quantity' => 'Tổng số lượng sản phẩm',
            'start_at' => 'Thời gian bắt đầu giảm giá',
            'end_at' => 'Thời gian kết thúc giảm giá',
            'publish' => 'Trạng thái mã giảm giá',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
