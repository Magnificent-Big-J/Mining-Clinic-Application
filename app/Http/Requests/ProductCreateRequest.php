<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_code' => 'required|string|unique:products',
            'product_name' => 'required|string|unique:products',
            'product_category' => 'required',
        ];
    }
    public function createProduct()
    {
        Product::create([
            'product_code' => $this->product_code,
            'product_category_id' => $this->product_category,
            'product_name' => $this->product_name,
            'product_description' => $this->product_description,
            'product_size' => $this->product_size,
            'product_unit' => $this->product_unit,
        ]);
    }
}
