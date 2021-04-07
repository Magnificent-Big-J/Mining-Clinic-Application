@extends('layouts.admindatatables')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Questionnaires</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Questionnaires</li>
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
                        <div class="table-responsive">
                            <a href="{{route('admin.medical.question')}}" class="mb-4 mr-4 btn btn-success">Add General Medical Examination Questions</a>
                            <a href="{{route('admin.screeningQuestionnaire.create')}}" class="mb-4 mr-4 btn btn-success">Add Covid-19 Questions</a>
                            <a href="{{route('admin.medical.question.with.specialities')}}" class="mb-4 btn btn-success">Add Specialities Medical Examination Questions </a>

                            <table class="table table-hover table-center mb-0" id="specialist">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Questionnaire</th>
                                    <th>Questionnaire Type</th>
                                    <th>Questionnaire Group</th>
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
@endsection
@section('scripts')
    <script>
        $(function () {
            $('#specialist').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('questionnaires.index') }}",
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'question', name: 'question'},
                    {data: 'question_type', name: 'question_type'},
                    {data: 'question_group', name: 'question_group'},
                    {data: 'edit', name: 'edit'},
                    {data: 'delete', name: 'delete'},
                ],
                'order':[],
                'columnDefs': [{
                    "targets": [0,4, 5],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
