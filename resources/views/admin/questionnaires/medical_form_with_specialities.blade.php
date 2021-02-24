@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Medical Examination Questionnaires Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Specialities</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-lg-12">

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-body">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h4 class="card-title"> Questionnaires

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
                                    <input type="hidden" name="question_type" id="question-type" class="form-control" value="{{\App\Models\ScreeningQuestionnaire::SPECIALITY_TYPE}}">

                                    <input type="hidden" name="question_type" value="2">
                                    <table class="table table-hover table-center">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px">Question name</th>
                                            <th style="min-width: 100px">Question Image</th>
                                            <th style="min-width: 100px">Question Specialities</th>
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
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>

        $(function (){
            $("#loader").hide();
            let count = 1;
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
                    url:'/api/store-questions-with-specialities',
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
                        }
                    }
                })
                $("#loader").hide();
                $('#save').attr('disabled', true);
            });

            function loadQuestionnaireForm(e) {

                axios.get(`/api/questionnaire/${count}/specialities`)
                    .then((response)=> {
                        $('#dynamic-column').append(response.data);

                            $('#qSpecialities_' + count).select2({
                                theme: "classic",
                                width: "resolve"
                            });
                        count++;
                    })
            }
        });
    </script>
@endsection
