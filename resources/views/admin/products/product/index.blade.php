@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Products</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                        <div class="table-responsive">
                            <a class="btn btn-secondary mb-4" data-toggle="modal" href="#product_modal"><i class="fa fa-plus-circle"></i> Add Product</a>
                            <table class="table table-hover table-center mb-0" id="product">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Category</th>
                                    <th>Product Size</th>
                                    <th>Product Unit</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>

    @include('admin.products.product.modals.product_modal')

@endsection
@section('scripts')
    <script>
        $(function () {
            $('#loader').hide();
            $('#product').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('product.categories.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'product_code', name: 'product_code'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'category', name: 'category'},
                    {data: 'product_size', name: 'product_size'},
                    {data: 'product_unit', name: 'product_unit'},
                    {data: 'actions', name: 'actions'},
                ]
            });


        });
    </script>
@endsection
