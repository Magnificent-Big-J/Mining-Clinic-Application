@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Product</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-md-12">

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.product.update', $product->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Product Name:<strong class="text-danger">*</strong></label>
                                <input type="text" name="product_name" class="form-control" id="product_name" value="{{$product->product_name}}" required>
                                @error('product_name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                   </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Product Code:<strong class="text-danger">*</strong></label>
                                <input type="text" name="product_code" class="form-control" id="product_code" value="{{$product->product_code}}" required>
                                @error('product_code')
                                <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                   </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Product Category:<strong class="text-danger">*</strong></label>
                                <select name="product_category" id="product-category" id="product_category" style="width: 100%" class="form-control select2-width" required>
                                    @foreach($productCategories as $productCategory)
                                        <option @if ($productCategory->id === $product->product_category_id) selected @endif  value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_category')
                                <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                   </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Product Size:</label>
                                <input type="text" name="product_size" placeholder="200 ml" class="form-control" id="product_size" value="{{$product->product_size}}" >
                            </div>
                            <div class="form-group">
                                <label for="">Product Unit:</label>
                                <input type="text" name="product_unit" placeholder="Bottle" class="form-control" id="product_unit" value="{{$product->product_unit}}">
                            </div>
                            <div class="form-group">
                                <label for="">Product Description:</label>
                                <textarea name="product_description" id="product_description" cols="10" rows="2" class="form-control">{{$product->product_description}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function () {

            $('#product-category').select2({
                theme: "classic",
                width: "resolve"
            });
        });
    </script>
@endsection
