<?php

namespace App\Http\Requests;

use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryCreateRequest extends FormRequest
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
            'name'=>'required|string|unique:product_categories'
        ];
    }
    public function createProductCategory()
    {
        ProductCategory::create(
            [
                'name' => $this->name
            ]
        );
        session()->flash('success', 'Product Category Successfully Created');
    }
}
