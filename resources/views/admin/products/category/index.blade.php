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
                    <h3 class="page-title">Product Categories</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Categories</li>
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
                            <a class="btn btn-secondary mb-4" data-toggle="modal" href="#product_category_modal"><i class="fa fa-plus-circle"></i> Add Product Category</a>
                            <table class="table table-hover table-center mb-0" id="product_category">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Category</th>
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

    @include('admin.products.category.modals.category_modal')
    @include('admin.products.category.modals.edit_category')

@endsection
@section('scripts')
    <script>
        $(function () {
            $('#loader').hide();
            $('#product_category').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('product.categories.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'actions', name: 'actions'},
                ]
            });
            $(document).on('click', '.product-edit-category',function (){
                let cat_id = $(this).attr('id');
                $('#loader').show();
                axios.get(`api/product-category/${cat_id}`)
                    .then((response)=>{
                        $('#loader').hide();
                        $("#name").val(response.data.name)
                        $("#category_id").val(response.data.id)
                    })
                    .catch((error)=>{
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong. Please contact support'
                        })
                    });
            });
            $(document).on('click', '.update-btn', function (e){
                e.preventDefault();

                $('#loader').show();
                if ($("#name").val() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Name cannot be empty'
                    })

                    return  false;
                }
                let cat_id = $("#category_id").val();
                axios.put(`api/product-category/${cat_id}/update`, {name: $("#name").val()})
                    .then((response)=>{
                        $('#loader').hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'OK',
                            text: response.data.message
                        })
                        location.reload();
                    })
                    .catch((error)=>{
                        $('#loader').hide();
                    })

            });
        });
    </script>
@endsection
