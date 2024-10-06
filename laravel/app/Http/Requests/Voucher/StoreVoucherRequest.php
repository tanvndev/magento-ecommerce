<?php

namespace App\Http\Requests\Voucher;

use App\Models\Voucher;
use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            'name'            => 'required',
            'value_type'      => 'required',
            'code'            => 'required|unique:vouchers',
            'value'           => 'required',
            'quantity'        => 'required|integer|min:1',
            'voucher_time'    => 'required',
            'condition_apply' => 'required',
        ];

        if ($this->condition_apply == Voucher::SUBTOTAL_PRICE) {
            $rules['subtotal_price'] = 'required';
        }

        if ($this->condition_apply == Voucher::MIN_QUANTITY) {
            $rules['min_quantity'] = 'required|integer|min:1';
        }

        if ($this->value_type == Voucher::TYPE_PERCENT) {
            $rules['value'] = 'required|integer|min:1|max:100';
        }

        if ($this->has('usage_limit')) {
            $rules['usage_limit'] = 'required|integer|min:1';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name'            => 'Tên mã giảm giá',
            'code'            => 'Mã giảm giá',
            'value'           => 'Giá trị',
            'value_type'      => 'Loại giá trị',
            'voucher_time'    => 'Thời gian',
            'condition_apply' => 'Điều kiện áp dụng',
            'quantity'        => 'Số lượng',
            'subtotal_price'  => 'Tổng giá trị đơn hàng tối thiểu',
            'min_quantity'    => 'Tổng số lượng sản phẩm được khuyến mại tối thiểu',
            'usage_limit'     => 'Giới hạn số lượng',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
