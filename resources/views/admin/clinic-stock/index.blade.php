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
                    <h3 class="page-title">Medication Inventory</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Medication Inventory</li>
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
                        <h4 class="card-title">Medication Inventory</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div name="search_form">
                                <div class="row">
                                    <input type="hidden" id="user" value="{{$user->id}}">
                                    <div class="col-lg-3 mb-4">
                                        <select name="clinic" id="clinic" class="form-control">
                                            @foreach($clinics as $clinic)
                                                <option value="{{$clinic->id}}">{{$clinic->mininig_name}} {{$clinic->clinic_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="col-lg-2 mb-4">
                                        <button type="button" class="btn btn-primary" id="search">Filter</button>
                                    </div>
                                    <div class="col-lg-2 mb-4">
                                        <button type="button" data-toggle="modal" href="#add-clinic-product-modal" class="btn btn-primary add-clinic-product" >Add Inventory Item</button>
                                    </div>
                                    <div class="col-lg-2 mb-4">
                                        <form action="{{route('export.mining.download')}}" method="get">
                                            <input type="hidden" name="clinic_id" id="clinic-id">
                                            <button type="submit" class="btn btn-primary" >Export</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-3 mb-4">
                                        <button class="btn btn-primary" id="push-level-primary">Push Stock Level Notification </button>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="table-responsive">

                            <table class="table table-hover table-center mb-0" id="clinic-products">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Category</th>
                                    <th>Product Quantity</th>
                                    <th>Product Price</th>
                                    <th>Product Threshold(Level)</th>
                                    <th>Edit</th>
                                    <th>View</th>
                                    <th>Add Stock</th>
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
@include('admin.clinic-stock.modals.add_stock')
@include('admin.clinic-stock.modals.edit_threshold')
@include('admin.clinic-stock.modals.show')
@include('admin.clinic-stock.modals.add_clinic_product')
@endsection
@section('scripts')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        let clinic;
        let user = $('#user').val();

        $(function () {
            $('#clinic-id').val($("#clinic").val());
            $('#loader').hide();
            fetch_data();
            $('#clinic-product-select').select2({
                theme: "classic",
                width: "resolve"
            });
            $('.add-clinic-product').click(function (){
                clinic = $("#clinic").val();

                $('#clinic-product').val(clinic);

            });
            $('#push-level-primary').click(function (){
                clinic = $("#clinic").val();

                axios.get(`../../api/stock/${clinic}/level-form/${user}`)
                .then((response)=>{
                    Swal.fire({
                        icon: 'success',
                        title: 'OK',
                        text: response.data.success
                    })
                })

            });
            function fetch_data(){
                clinic = $("#clinic").val();

                $('#clinic-products').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `clinic-product/${clinic}/data`,
                        type:"POST",
                        data:{
                            "_token": "{{ csrf_token() }}"
                        }
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'product_code', name: 'product_code'},
                        {data: 'product_name', name: 'product_name'},
                        {data: 'product_category', name: 'product_category'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'product_price', name: 'product_price'},
                        {data: 'threshold', name: 'threshold'},
                        {data: 'edit', name: 'edit'},
                        {data: 'view', name: 'view'},
                        {data: 'add_stock', name: 'add_stock'},
                    ],
                    'order':[],
                    'columnDefs': [{
                    "targets": [0,7,8, 9],
                    "orderable": false
                    }]
                });
               $("#clinic").val(clinic);
            }
            $('#clinic').change(function (){
                clinic = $("#clinic").val();
                $('#clinic-id').val(clinic);
            });
            $('#search').click(function(){

                $('#clinic-products').DataTable().destroy();
                fetch_data();
            })
            $(document).on('click', '.show-clinic-stock', function (){
                $('#loader').show();
                let clinic_product = $(this).attr('id');

                axios.get(`../../api/clinic-product/${clinic_product}/show`)
                    .then((response)=>{
                        $('#loader').hide();
                        $('.info-details').html(response.data)

                    })
                    .catch((error)=>{
                        $('#loader').hide();
                    })
            });
            $(document).on('click', '.edit-clinic-threshold', function (e) {
                e.preventDefault();
                $('#loader').show();
                let clinic_product = $(this).attr('id');

                axios.get(`../../api/clinic-product/${clinic_product}/product`)
                    .then((response)=>{
                        $('#loader').hide();
                        $('.edit-heading').html('Now updating: ' + response.data.product_name)
                        $('#price').val(response.data.price)
                        $('#threshold').val(response.data.threshold)
                        $('#clinic-product-value').val(clinic_product);
                    })
                    .catch((error)=>{
                        $('#loader').hide();
                    })
            });
            $(document).on('click', '.add-clinic-stock', function (){
                $('#loader').show();
                let clinic_product = $(this).attr('id');

                axios.get(`../../api/clinic-product/${clinic_product}/product-name`)
                    .then((response)=>{
                        $('#loader').hide();
                        $('.clinic-add-heading').html('Add Stock For A Product: ' + response.data.product_name)
                        $('#stock').val(clinic_product);

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

                axios.post(`../../api/clinic-product/${stock}/store`, {product_quantity: $('#product_quantity').val(), stock_date: $('#stock_date').val()})
                    .then((response)=>{
                        $('#loader').hide();
                        responseAlert(response.data.message)
                       // location.reload();
                    })
                    .catch((error)=> {
                        $('#loader').hide();
                    })

            });
            $(document).on('click', '.update-clinic-btn', function (e){
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
                let clinicProduct = $('#clinic-product-value').val();


                axios.put(`../../api/clinic-product/${clinicProduct}/update`, {price: $('#price').val(), threshold: $('#threshold').val()})
                    .then((response)=>{
                        $('#loader').hide();
                        responseAlert(response.data.message)
                        //
                    })
                    .catch((error)=> {
                        $('#loader').hide();
                    })

            });
            $(document).on('click', '.submit-click-product-btn', function (e){
                e.preventDefault();
                $('#loader').show();
                if ($('#clinic-product-select').val() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select products to add.'
                    });
                    return false;
                }

                let options = $('#clinic-product-select option:selected');

                let clinicProducts = $.map(options ,function(option) {
                    return option.value;
                });

                axios.post(`../../api/click-product-store`, {clinicProducts, clinic: $('#clinic-product').val()})
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
                Swal.fire({
                    icon: 'success',
                    title: 'OK',
                    text: message
                }).then(function() {
                    location.reload();
                });

            }
        });
    </script>
@endsection
