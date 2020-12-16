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
                    <h3 class="page-title">Product Stock History</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Product Stock History</li>
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
                        <h4 class="card-title">Product Stock History for: {{$doctor->entity_name}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="mb-4">
                                <form name="search_form" action="{{route('export.doctor.download')}}" method="get">
                                    <div class="row">
                                        <input type="hidden" name="doctor" value="{{$doctor->id}}">
                                        <div class="col-lg-3">

                                            <input type="date" name="from_date" id="from_date" class="form-control">
                                        </div>
                                        <div class="col-lg-3">

                                            <input type="date" name="to_date" id="to_date" class="form-control">
                                        </div>
                                        <div class="col-lg-3 ">
                                            <button type="button" class="btn btn-primary" id="search">Search</button>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="submit" class="btn btn-primary" id="export">Export</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                            <table class="table table-hover table-center mb-0" id="stocks">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Category</th>
                                    <th>Product Quantity</th>
                                    <th>Product Price</th>
                                    <th>Stock Date</th>
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

@endsection
@section('scripts')

    <script>
        $(function () {

            fetch_data();

            function fetch_data(start_date='', end_date='')
            {
                $('#stocks').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('doctor.stock.data.index', $doctor->id) }}",
                        type:"POST",
                        data:{
                           start_date:start_date, end_date:end_date,
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
                        {data: 'stock_date', name: 'stock_date'},
                    ],

                });
            }
            $('#search').click(function(){
                if ($("#from_date").val() == '' && $("#to_date").val() == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select from date and to date'
                    })

                    return  false;
                }
                $('#stocks').DataTable().destroy();
                fetch_data($("#from_date").val(), ("#to_date").val());

            })
        });
    </script>
@endsection
