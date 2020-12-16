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
                    <div class="card-header">
                        <h4 class="card-title">{{$doctor->entity_name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="mb-4">
                                <a class="btn btn-secondary " data-toggle="modal" href="#doctor-product-modal"><i class="fa fa-plus-circle"></i> Add Doctor Product</a>
                                <a href="{{route('admin.historic.doctor.product.index', $doctor->id)}}" class="btn btn-info">View Stock History</a>
                            </div>
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
    @include('admin.doctors.modals.add_doctor_product')
    @include('admin.doctors.modals.edit_threshold')
    @include('admin.doctors.modals.add_stock')
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $(function () {
            $('#loader').hide();
            $('#doctor-product').select2({
                theme: "classic",
                width: "resolve"
            });
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
            $(document).on('click', '.submit-btn', function (e){
                e.preventDefault();
                $('#loader').show();
                if ($('#doctor-product').val() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select products to add.'
                    });
                    return false;
                }

                let options = $('#doctor-product option');

                let doctorProducts = $.map(options ,function(option) {
                    return option.value;
                });

                axios.post(`../../api/doctor-product-store`, {doctorProducts, doctor: $('#doctor').val()})
                .then((response)=>{
                    $('#loader').hide();
                    responseAlert(response.data.message)
                    location.reload();
                })
                .catch((error)=> {
                    $('#loader').hide();
                })

            });

            $(document).on('click', '.update-threshold', function (e) {
                e.preventDefault();
                $('#loader').show();
                let doctor_product = $(this).attr('id');

                axios.get(`../../api/doctor-product/${doctor_product}/product`)
                    .then((response)=>{
                        $('#loader').hide();
                        $('.modal-title').html('Now updating :' + response.data.product_name)
                        $('#price').val(response.data.price)
                        $('#threshold').val(response.data.threshold)
                        $('#doctor-product-value').val(doctor_product)
                    })
                    .catch((error)=>{
                        $('#loader').hide();
                    })
            })
            $(document).on('click', '.update-btn', function (e){
                e.preventDefault();
                $('#loader').show();
                if ($('#price').val() === '' && ('#threshold').val() === '' ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Threshold and Price Cannot be empty.'
                    });
                    return false;
                }
                let doctorProduct = $('#doctor-product-value').val();


                axios.put(`../../api/doctor-product/${doctorProduct}/update`, {price: $('#price').val(), threshold: $('#threshold').val()})
                    .then((response)=>{
                        $('#loader').hide();
                        responseAlert(response.data.message)
                        location.reload();
                    })
                    .catch((error)=> {
                        $('#loader').hide();
                    })

            });
            $(document).on('click', '.add-stock', function (){
                $('#loader').show();
                let doctor_product = $(this).attr('id');

                axios.get(`../../api/doctor-product/${doctor_product}/product-name`)
                    .then((response)=>{
                        $('#loader').hide();
                        $('.modal-title').html('Add Stock For A Product :' + response.data.product_name)
                        $('#stock').val(doctor_product);

                    })
                    .catch((error)=>{
                        $('#loader').hide();
                    })
            });
            $(document).on('click', '.add-stock-btn', function (e){
                e.preventDefault();
                $('#loader').show();
                if ($('#product_quantity').val() === '' && $('#stock_date').val() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Quantity and Date Cannot Be Empty.'
                    });
                    return false;
                }
                let stock = $('#stock').val()

                axios.post(`../../api/doctor-product/${stock}/store`, {product_quantity: $('#product_quantity').val(), stock_date: $('#stock_date').val()})
                    .then((response)=>{
                        $('#loader').hide();
                        responseAlert(response.data.message)
                        location.reload();
                    })
                    .catch((error)=> {
                        $('#loader').hide();
                    })

            });

            function responseAlert(message)
            {
                setTimeout(function(){ Swal.fire({
                    icon: 'success',
                    title: 'OK',
                    text: message
                }); }, 3000);

            }

        });
    </script>
@endsection
