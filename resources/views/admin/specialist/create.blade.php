@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Specialities Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Specialities</li>
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
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h4 class="card-title"> Specialities

                                </h4>
                            </div>
                            <div class="card-body">
                                <!-- Add Item -->
                                <div class="add-more-item text-right" style="cursor: pointer;">
                                    <button class="btn btn-primary"  id="add-column"><i class="fa fa-plus"></i> Add Item</button>
                                </div>
                                <div id="loader"></div>
                                <span id="result"></span>
                                <form form method="post" id="dynamic-form" enctype="multipart/form-data" action="javascript:void(0)">
                                    @csrf

                                    <table class="table table-hover table-center">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px">Specialities Name</th>
                                            <th style="min-width: 100px">Specialities Image</th>
                                            <th style="min-width: 80px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="dynamic-column">

                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary ">
                                    </div>
                                </form>

                            </div>
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

        $(function (){
            $("#loader").hide();

            loadQuestionnaireForm();
            $('#add-column').click(function (){
                loadQuestionnaireForm();
            });
            $(document).on('click', '.remove', function(){
                $(this).closest("tr").remove();
            });
            $('#dynamic-form').on('submit',function (e){
                e.preventDefault();
                $("#loader").show();
                let formData = new FormData(this);

                $.ajax({
                    url:'/api/store-specialities',
                    method:'post',
                    data:formData,
                    // dataType:'json',
                    cache:false,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('#save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {

                        if(data.error)
                        {
                            var error_html = '';
                            for(var count = 0; count < data.error.length; count++)
                            {
                                error_html += '<p>'+data.error[count]+'</p>';
                            }
                            $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                        }
                        else
                        {
                            $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                            window.setTimeout(function () {
                                window.location = data.url;
                            }, 1000);
                        }
                    }
                })
                $("#loader").hide();
                $('#save').attr('disabled', true);
            });

            function loadQuestionnaireForm(e) {
                axios.get(`/api/specialities-form`)
                    .then((response)=> {
                        $('#dynamic-column').append(response.data);

                    })
            }
        });
    </script>
@endsection

