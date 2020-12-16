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
                    <h3 class="page-title">Product Stock</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Stock</li>
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
                            {{--<a class="btn btn-secondary mb-4" data-toggle="modal" href="#product_modal"><i class="fa fa-plus-circle"></i> Add Product</a>--}}
                            <table class="table table-hover table-center mb-0" id="product">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Category</th>
                                    <th>Product Quantity</th>
                                    <th>Product Price</th>
                                    <th>Product Threshold(Level)</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <div id="loader"></div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>
    </div>
    @include('admin.doctors.modals.doctor_product_show')
@endsection
@section('scripts')

    <script>
        $(function () {
            $('#loader').hide();
            $('#product').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('doctor.products.index', $doctor->id) }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'product_code', name: 'product_code'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'product_category', name: 'product_category'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'product_price', name: 'product_price'},
                    {data: 'threshold', name: 'threshold'},
                    {data: 'actions', name: 'actions'},
                ],

            });
            $(document).on('click', '.show-product', function (){
                $('#loader').show();
               let doctor_product = $(this).attr('id');

                axios.get(`../../api/doctor-product/${doctor_product}/show`)
                    .then((response)=>{
                        $('#loader').hide();
                       $('.info-details').html(response.data)

                    })
                    .catch((error)=>{
                        $('#loader').hide();
                    })
            });

        });
    </script>
@endsection
