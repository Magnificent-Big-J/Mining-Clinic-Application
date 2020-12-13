@extends('layouts.admindatatables')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('css/main.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Update Consultation</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consultation</li>
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
                                <h4 class="card-title">Update Consultation</h4>
                            </div>
                            <div class="card-body">

                                <form action="{{route('admin.consultation.update', $consultation->id)}}" method="post" >
                                    @method('PUT')
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group ">
                                                <label  for="">Name: <strong class="text-danger">*</strong></label>
                                                <input type="text" name="name" class="form-control" value="{{$consultation->name}}" required>
                                                @error('name')
                                                <span class="text-danger" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                    </span>
                                                                        @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group ">
                                                <label for="">Consultation Type: <strong class="text-danger">*</strong></label>
                                                <br>
                                                <select name="consultation_type" id="consultation-type" style="width: 100%" class="form-control select2-width" required>
                                                    @foreach($consultationCategories as $consultationCategory)
                                                        <option @if ($consultation->consultation_category_id === $consultationCategory->id) selected @endif  value="{{$consultationCategory->id}}">{{$consultationCategory->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('consultation_type')
                                                <span class="text-danger" role="alert">
                                                       <strong>{{ $message }}</strong>
                                                 </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <input type="submit" value="Update" class="btn btn-primary booking">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(function (){
            $('#consultation-type').select2({
                theme: "classic",
                width: "resolve"
            });

        });
    </script>
@endsection

