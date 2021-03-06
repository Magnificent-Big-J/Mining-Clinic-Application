@extends('layouts.admindatatables')
@section('styles')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
@endsection

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Doctors Management</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update Doctor Information</li>
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
                                <h4 class="card-title">Doctor Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.doctors.update', $doctor->id)}}" method="post" >
                                    @csrf
                                    @method('PUT')
                                    @include('admin.doctors.partials.edit')
                                    @if($doctor->has_entity === \App\Models\Doctor::HAS_ENTITY_STATE)
                                        <hr>
                                        <h4 class="card-title">Entity Information</h4>
                                        @include('admin.doctors.partials.editEntity')
                                    @endif
                                    <hr>
                                    <h4 class="card-title">Address Information</h4>
                                    @include('admin.doctors.partials.editAddress')
                                    <input type="submit" value="Update" class="btn btn-primary ">
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
        $('#specialist-name-update').select2({
            theme: "classic",
            width: "resolve"
        });
    </script>
@endsection
