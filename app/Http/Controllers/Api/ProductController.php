<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function editCategory(ProductCategory $productCategory)
    {
        return $productCategory;
    }
    public function updateCategory(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        $request->updateProductCategory($productCategory);

        return [
            'message' => 'Category Successfully Updated'
        ];
    }
}
