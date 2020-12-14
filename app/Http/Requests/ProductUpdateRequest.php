<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'product_code' => 'required|string|unique:products,product_code,' . $this->product->id,
            'product_name' => 'required|string|unique:products,product_name,' . $this->product->id,
            'product_category' => 'required',
        ];
    }
    public function updateProduct($product)
    {
        $product->product_code = $this->product_code;
        $product->product_category_id = $this->product_category;
        $product->product_name = $this->product_name;
        $product->product_description = $this->product_description;
        $product->product_size = $this->product_size;
        $product->product_unit = $this->product_unit;
        $product->save();

        session()->flash('success', 'Product Successfully Updated');
    }
}
