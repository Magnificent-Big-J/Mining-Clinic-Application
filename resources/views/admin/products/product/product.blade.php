<input type="hidden" name="product" id="productDD" value="{{$product->id}}">
<div class="form-group">
    <label for="" class="font-weight-bold">Product Name:<span class="text-danger">*</span></label>
    <input type="text" name="product_name" class="form-control" id="product-name2" value="{{$product->product_name}}" required>
    <small id="product-name-error" class="text-danger"></small>
</div>
<div class="form-group">
    <label for="" class="font-weight-bold">Product Code:<span class="text-danger">*</span></label>
    <input type="text" name="product_code" class="form-control" id="product-code2"  value="{{$product->product_code}}" required>
    <small id="product-code-error" class="text-danger"></small>
</div>
<div class="form-group">
    <label for="" class="font-weight-bold">Product Category:<span class="text-danger">*</span></label>
    <select name="product_category" id="product-category" style="width: 100%" class="form-control select2-width" required>
        @foreach($productCategories as $productCategory)
            <option @if ($productCategory->id ===  $product->product_category_id) selected @endif value="{{$productCategory->id}}">{{$productCategory->name}}</option>
        @endforeach
    </select>
    <small id="product-category-error" class="text-danger"></small>
</div>
<div class="form-group">
    <label for="" class="font-weight-bold">Product Size:</label>
    <input type="text" name="product_size" placeholder="200 ml" class="form-control" id="product-size2"  value="{{$product->product_size}}" >
</div>
<div class="form-group">
    <label for="" class="font-weight-bold">Product Unit:</label>
    <input type="text" name="product_unit" placeholder="Bottle" class="form-control" id="product-unit2"  value="{{$product->product_unit}}" >
</div>
<div class="form-group">
    <label for="" class="font-weight-bold">Product Description:</label>
    <textarea name="product_description" id="product-description2" cols="10" rows="2" class="form-control">{{$product->product_description}}</textarea>
</div>
