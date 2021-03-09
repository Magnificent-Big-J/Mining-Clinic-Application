<input type="hidden" name="product" id="productDD" value="{{$product->id}}">
<div class="form-group">
    <label for="">Product Name:<strong class="text-danger">*</strong></label>
    <input type="text" name="product_name" class="form-control" id="product-name2" value="{{$product->product_name}}" required>
    <small id="product-name-error" class="text-danger"></small>
</div>
<div class="form-group">
    <label for="">Product Code:<strong class="text-danger">*</strong></label>
    <input type="text" name="product_code" class="form-control" id="product-code2"  value="{{$product->product_code}}" required>
    <small id="product-code-error" class="text-danger"></small>
</div>
<div class="form-group">
    <label for="">Product Category:<strong class="text-danger">*</strong></label>
    <select name="product_category" id="product-category" style="width: 100%" class="form-control select2-width" required>
        @foreach($productCategories as $productCategory)
            <option @if ($productCategory->id ===  $product->product_category_id) selected @endif value="{{$productCategory->id}}">{{$productCategory->name}}</option>
        @endforeach
    </select>
    <small id="product-category-error" class="text-danger"></small>
</div>
<div class="form-group">
    <label for="">Product Size:</label>
    <input type="text" name="product_size" placeholder="200 ml" class="form-control" id="product-size2"  value="{{$product->product_size}}" >
</div>
<div class="form-group">
    <label for="">Product Unit:</label>
    <input type="text" name="product_unit" placeholder="Bottle" class="form-control" id="product-unit2"  value="{{$product->product_unit}}" >
</div>
<div class="form-group">
    <label for="">Product Description:</label>
    <textarea name="product_description" id="product-description2" cols="10" rows="2" class="form-control">{{$product->product_description}}</textarea>
</div>
