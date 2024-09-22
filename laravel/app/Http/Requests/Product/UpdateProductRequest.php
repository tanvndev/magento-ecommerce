<?php



namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name'                 => 'required|string',
            'product_type'         => 'required',
            'product_catalogue_id' => 'required',
        ];

        $product = Product::find($this->product);
        if ($product && $product->product_type === 'variable') {
            $rules['product_type'] = 'required|in:variable';
        }

        if ($this->has('upsell_ids') && count($this->upsell_ids)) {
            $rules['upsell_ids'] = 'array|min:4|max:50';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'name'                 => 'Tiêu đề sản phẩm',
            'product_type'         => 'Loại sản phẩm',
            'product_catalogue_id' => 'Nhóm sản phẩm',
            'upsell_ids'           => 'Sản phẩm liên kết',
        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'product_type.in' => 'Bạn không thể chuyển loại sản phẩm vui lòng thử lại.',
        ];
    }
}
