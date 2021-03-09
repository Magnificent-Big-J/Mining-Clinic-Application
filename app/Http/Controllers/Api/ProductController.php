<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
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
    public function productStore(ProductCreateRequest $request)
    {
        $request->createProduct();
        return [
            'message' => 'Product Successfully Created'
        ];
    }

    public function edit(Product $product)
    {
        return view('admin.products.product.product',compact('product'));
    }
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $request->updateProduct($product);
       return response()->json(['success'=> 'Product Successfully Updated']);
    }
}
