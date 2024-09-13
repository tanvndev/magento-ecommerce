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
        return [
            'code'              => 'required|max:50',
            'discount_type'     => 'required',
            'discount_value'    => 'required',
            'quantity'          => 'required|integer',
            'min_order_value'   => 'required|integer',
            'min_quantity'      => 'required|integer',
            'start_at'          => 'required|date',
            'end_at'            => 'required|date',
            'publish'           => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'code'              => 'Mã giảm giá',
            'discount_type'     => 'Kiểu giá trị giảm giá',
            'discount_value'    => 'Giá trị giảm giá',
            'quantity'          => 'Số lượng mã giảm giá',
            'min_order_value'   => 'Tổng giá trị đơn hàng tối thiểu',
            'min_quantity'      => 'Tổng số lượng sản phẩm',
            'start_at'          => 'Thời gian bắt đầu giảm giá',
            'end_at'            => 'Thời gian kết thúc giảm giá',
            'publish'           => 'Trạng thái mã giảm giá',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }
}
