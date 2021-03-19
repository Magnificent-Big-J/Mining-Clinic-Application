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
                            <a href="{{route('admin.product.export')}}" class="btn btn-success float-right">Export</a>
                            <table class="table table-hover table-center mb-0" id="product">
                                <thead>
                                <tr>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Category</th>
                                    <th>Product Size</th>
                                    <th>Product Unit</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
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
    @include('admin.products.product.modals.product_edit_modal')

@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>

        $(function () {
            $('#product-categories').select2({
                theme: "classic",
                width: "resolve"
            });
            $('#product-category').select2({
                theme: "classic",
                width: "resolve"
            });

            $('#loader').hide();
            $('#product').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('product.index') }}",
                },
                columns: [
                    {data: 'product_code', name: 'product_code'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'category', name: 'category'},
                    {data: 'product_size', name: 'product_size'},
                    {data: 'product_unit', name: 'product_unit'},
                    {data: 'edit', name: 'edit'},
                    {data: 'delete', name: 'delete'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [5,6],
                    "orderable": false
                }]
            });
            $(document).on('click', '.product-edit-category', function (){
               let product = $(this).attr('id');

               axios.get(`api/product/${product}`)
                .then((response)=>{
                   $('#loader').hide();

                   $('.product-result').html(response.data)


                });
            });
            $(document).on('click', '.submit-btn', function (e){
                e.preventDefault();

                $('#loader').show();
                if ($("#product_code").val() == '' && $("#product_name").val() == '' && $("#product_code").val() == '') {
                    $('#loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Product name, Product code and product category cannot be empty'
                    });
                    return  false;
                }

                axios.post('api/product-category', {product_code: $("#product_code").val(), product_name: $("#product_name").val(),
                    product_category: $("#product-categories").val(), product_size: $("#product_size").val(),
                    product_unit: $("#product_size").val(),
                })
                    .then((response)=>{
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: response.data.message
                        }).then(function() {
                            location.reload();
                        });
                    })
                    .catch((error)=>{
                        $('#loader').hide();
                        let errors = error.response.data.errors;
                        if (errors.product_code) {
                            $('#product_code_error').html(errors.product_code[0]);
                        }
                        if (errors.product_name) {
                            $('#product_name_error').html(errors.product_name[0]);
                        }
                    })
            });
            $(document).on('submit', '#product-edit-form', function (e){
                e.preventDefault();
                if ($("#product-code2").val() == '' && $("#product-name2").val() == '' && $("#product-code2").val() == '') {
                    $('#loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Product name, Product code and product category cannot be empty'
                    });
                    return  false;
                }

               let product = document.getElementById('productDD').value;

                axios.put(`../../api/product/${product}/update`, {'product_name': $('#product-name2').val(),
                        'product_code': $('#product-code2').val(), 'product_category': $('#product-category').val(),
                        'product_size': $('#product-size2').val(), 'product_unit': $('#product-unit2').val(),
                        'product_description': $('#product-description2').val()
                    })
                    .then((response)=>{
                        $("#loader").hide();
                        Swal.fire({
                            icon: 'success',
                            text: response.data.success
                        }).then(function () {
                                location.reload();
                        });
                    })
                    .catch((error)=> {
                        $("#loader").hide();
                        let errors = error.response.data.errors;
                        //
                        if (errors.product_name) {
                            $('#product-name-error').html(errors.product_name[0]);
                        }
                        if (errors.product_code) {
                            $('#product-code-error').html(errors.product_code[0]);
                        }
                        if (errors.product_category) {
                            $('#product-category-error').html(errors.product_category[0]);
                        }
                    });

            });


        });
    </script>
@endsection
